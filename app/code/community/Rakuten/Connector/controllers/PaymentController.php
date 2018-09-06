<?php
/**
 ************************************************************************
 * Copyright [2017] [RakutenPay]
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ************************************************************************
 */

/**
 * Class Rakuten_Connector_RakutenPay_PaymentController
 */
class Rakuten_Connector_PaymentController extends Mage_Core_Controller_Front_Action
{
    /**
     * @var Rakuten_RakutenPay_Model_PaymentMethod
     */
    private $payment;

    /**
     * Rakuten_RakutenPay_PaymentController constructor.
     */
    public function _construct()
    {
        \RakutenPay\Resources\Log\Logger::info('Constructing PaymentController.');
        $this->payment = new Rakuten_Connector_Model_RakutenPay_PaymentMethod();
    }

    public function canceledAction()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing canceledAction.');
        $order = Mage::getModel('sales/order')->load($this->getCheckout()->getLastOrderId());
        $this->canceledStatus($order);

        return $this->loadAndRenderLayout();
    }

    /**
     * @return Mage_Core_Model_Abstract
     */
    private function getCheckout()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getCheckout.');
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Cancel order
     *
     * @param $order
     */
    private function canceledStatus($order)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing canceledStatus.');
        $order->cancel();
        $order->save();
    }

    /**
     * @param array $items
     *
     * @param bool  $returnAaJson
     *
     * @return $this
     */
    private function loadAndRenderLayout(Array $items = [], $returnAaJson = false)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing loadAndRenderLayout.');
        if ($returnAaJson) {
            $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
            $this->getResponse()->setBody(json_encode($items));
        } else {
            $this->loadLayout();
            foreach ($items as $k => $item) {
                Mage::register($k, $item);
            }
            $this->renderLayout();
        }

        return $this;
    }

    /**
     * @return Rakuten_RakutenPay_PaymentController
     */
    public function defaultAction()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing defaultAction in PaymentController.');
        $link = null;

        try {
            /** @var Mage_Sales_Model_Order $order */
            $order = Mage::getModel('sales/order')->load($this->getCheckout()->getLastOrderId());
            $this->payment->setOrder($order);
            /**
             * @var \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard $payment
             */

            $payment = $this->payment->paymentDefault();

            $this->payment->addRakutenpayOrders($order);
            $this->payment->clearCheckoutSession($order);
            /**
             * @var \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard $result
             */
            $link = $this->payment->paymentRegister($payment);
            $order->sendNewOrderEmail();
        } catch (Exception $exception) {
            \RakutenPay\Resources\Log\Logger::error($exception);
            Mage::logException($exception);
            $this->canceledStatus($order);
        }

        return $this->loadAndRenderLayout([
            'link' => $link,
        ]);
    }

    /**
     * @return Rakuten_RakutenPay_PaymentController
     */
    public function directAction()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing directAction.');
        $paymentSession = null;
        $order          = null;
        $link           = null;
        $result         = null;
        $json           = false;
        $redirect       = null;

        try {
            \RakutenPay\Resources\Log\Logger::info('Processing directAction in PaymentController.');
            /** @var Mage_Sales_Model_Order $order */
            $order = Mage::getModel('sales/order')->load($this->getCheckout()->getLastOrderId());
            \RakutenPay\Resources\Log\Logger::info('Loaded the order.');

            $customerPaymentData = Mage::getSingleton('customer/session')->getData();
            \RakutenPay\Resources\Log\Logger::info('Got the payment data.');

            $this->payment->setOrder($order);
            /**
             * @var \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard $payment
             */
            \RakutenPay\Resources\Log\Logger::info('Getting the payment data.');
            $payment = $this->payment->paymentDirect($order->getPayment()->getMethod(), $customerPaymentData);
            \RakutenPay\Resources\Log\Logger::info('Got the payment data.');
            $this->payment->addRakutenpayOrders($order);
            \RakutenPay\Resources\Log\Logger::info('Added the orders.');
            $this->payment->clearCheckoutSession($order);
            \RakutenPay\Resources\Log\Logger::info('Cleared checkout session.');
            /**
             * @var \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard $result
             */
            $result = $this->payment->paymentRegister($payment);
            \RakutenPay\Resources\Log\Logger::info('Registered the payment.');

            if ($result === false) {
                \RakutenPay\Resources\Log\Logger::error('Result is false...');
                $this->canceledStatus($order);
                return Mage_Core_Controller_Varien_Action::_redirect('rakutenpay/payment/error', array('_secure'=> false));
            }
            /** controy redirect url according with payment return link **/
            if (method_exists($result, 'getBillet') && $result->getBillet()) {
                $link     = $result->getBillet();

                $payment = $order->getPayment();
                $payment
                    ->setAdditionalInformation('billet_url', $link)
                    ->setAdditionalInformation('rakutenpay_id', $result->getId())
                    ->save();

                $redirect = 'rakutenpay/payment/success';
                $redirectParams = array('_secure'=> false, '_query'=> array('billet' => $link));
            } else {
                $payment = $order->getPayment();
                $payment
                    ->setAdditionalInformation('rakutenpay_id', $result->getId())
                    ->save();
                $redirect = 'rakutenpay/payment/success';
                $redirectParams = array();
            }
            \RakutenPay\Resources\Log\Logger::info('Redirect params: $redirect: ' . var_export($redirect, true) . '\n $redirectParams: ' . var_export($redirectParams, true));
            $order->sendNewOrderEmail();

        } catch (\Exception $exception) {
            \RakutenPay\Resources\Log\Logger::error('Got an exception: ' . var_export($exception, true));
            $this->canceledStatus($order);
            return Mage_Core_Controller_Varien_Action::_redirect('rakutenpay/payment/error', array('_secure'=> false));
        }

        return  Mage_Core_Controller_Varien_Action::_redirect(
            $redirect,
            $redirectParams
        );
    }

    /**
     * Process the request by checkout type
     */
    public function requestAction()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing requestAction in PaymentController.');
        $order = Mage::getModel('sales/order')->load($this->getCheckout()->getLastOrderId());
        $orderPaymentMethod = $order->getPayment()->getMethod();

        if ($orderPaymentMethod === 'rakutenpay_boleto' ||$orderPaymentMethod === 'rakutenpay_credit_card') {
            $this->_redirectUrl(Mage::getUrl('rakutenpay/payment/direct'));
        } else {
            \RakutenPay\Resources\Log\Logger::error('Método de pagamento inválido para o RakutenPay');
            return Mage_Core_Controller_Varien_Action::_redirect('rakutenpay/payment/error', array('_secure'=> false));
        }
    }

    /**
     * @return Rakuten_RakutenPay_PaymentController
     */
    public function successAction()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing successAction in PaymentController.');
        return $this->loadAndRenderLayout();
    }

    /**
     * Default payment error screen
     * @return Rakuten_RakutenPay_PaymentController
     */
    public function errorAction()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing errorAction in PaymentController.');
        return $this->loadAndRenderLayout();
    }

}
