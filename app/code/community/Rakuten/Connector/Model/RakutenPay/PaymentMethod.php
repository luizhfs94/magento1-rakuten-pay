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
 * @property Mage_Sales_Model_Order order
 */
class Rakuten_Connector_Model_RakutenPay_PaymentMethod extends Mage_Payment_Model_Method_Abstract
{
    protected $_canAuthorize = true;
    protected $_canCapture = true;
    protected $_canCapturePartial = false;
    protected $_canRefund = false;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = true;
    protected $_canUseInternal = true;
    protected $_canVoid = true;
    protected $_code = 'rakutenpay_default_lightbox';
    protected $_isGateway = true;
    /**
     * @var Mage_Sales_Model_Order
     */
    protected $order;
    /**
     * @var Rakuten_RakutenPay_Helper_Data
     */
    private $helper;
    /**
     * @var Rakuten_RakutenPay_Model_Library
     */
    private $library;

    protected $_session;

    /**
     * Rakuten_RakutenPay_Model_PaymentMethod constructor.
     */
    public function __construct()
    {
        \RakutenPay\Resources\Log\Logger::info('Constructing PaymentMethod.');
        $this->library = new Rakuten_RakutenPay_Model_Library();
        $this->helper = new Rakuten_RakutenPay_Helper_Data();
    }

    /**
     * @param Mage_Sales_Model_Order $order
     */
    public function addRakutenpayOrders(Mage_Sales_Model_Order $order)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing addRakutenpayOrders.');
        $orderId = $order->getEntityId();
        $enviroment = $this->library->getEnvironment();
        $table = Mage::getConfig()->getTablePrefix().'rakutenpay_orders';
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $value = $read->query("SELECT `order_id` FROM `$table` WHERE `order_id` = $orderId");
        if (!$value->fetch()) {
            $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
            $sql = "INSERT INTO `$table` (`order_id`, `environment`) VALUES ('$orderId', '$enviroment')";
            $connection->query($sql);
        }
    }

    /**
     * @param Mage_Sales_Model_Order $order
     */
    public function clearCheckoutSession(Mage_Sales_Model_Order $order)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing clearCheckoutSession.');
        $cart = Mage::getSingleton('checkout/cart');
        foreach (Mage::getSingleton('checkout/session')->getQuote()->getItemsCollection() as $item) {
            $cart->removeItem($item->getId());
        }
        $cart->save();
        $order->save();
    }

    /**
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getOrderPlaceRedirectUrl.');
        return Mage::getUrl('rakutenpay/payment/request');
    }

    /**
     * Retrieve checkout type from system.xml
     *
     * @return mixed
     */
    public function getPaymentCheckoutType()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getPaymentCheckoutType.');
        return $this->library->getPaymentCheckoutType();
    }

    /**
     * @return mixed
     */
    public function getPaymentSession()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getPaymentSession.');
        return \Mage::getSingleton('checkout/session');;
//        return \RakutenPay\Services\Session::create($this->library->getAccountCredentials());
    }

    /**
     * @return \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard
     */
    public function paymentDefault()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing paymentDefault.');
        $payment = new \RakutenPay\Domains\Requests\Payment();

        return $this->payment($payment);
    }

    /**
     * @param \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard|\RakutenPay\Domains\Requests\Payment $payment
     *
     * @return \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard
     */
    private function payment($payment)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing payment.');
        $shippingAddress = $this->order->getShippingAddress();
        if ($shippingAddress === false) {
            $shippingAddress = $this->order->getBillingAddress();
        }

        \RakutenPay\Resources\Log\Logger::info('Setting payment info...');
        $payment->setReference($this->order->getId());
        \RakutenPay\Resources\Log\Logger::info('Reference set.');
        $payment->setCurrency('BRL');
        \RakutenPay\Resources\Log\Logger::info('Currency set.');
        $payment->setTotal($this->order->getGrandTotal());
        \RakutenPay\Resources\Log\Logger::info('Total set.');
        $this->setItems($payment);
        \RakutenPay\Resources\Log\Logger::info('Items set.');
        $payment->setSender()->setName($this->order->getCustomerName());
        \RakutenPay\Resources\Log\Logger::info('Name set.');
        $payment->setSender()->setEmail($this->order->getCustomerEmail());
        \RakutenPay\Resources\Log\Logger::info('Email set.');
        $phone = $this->helper->formatPhone($shippingAddress->getTelephone());
        \RakutenPay\Resources\Log\Logger::info('Phone formatted.');
        $payment->setSender()->setPhone()->withParameters($phone['areaCode'], $phone['number']);
        \RakutenPay\Resources\Log\Logger::info('Phone set.');
        $orderAddress = new Rakuten_RakutenPay_Model_OrderAddress($this->order);
        \RakutenPay\Resources\Log\Logger::info('Order address created.');
        if (method_exists($orderAddress, 'getShippingAddress()')) {
            $payment->setShipping()->setAddress()->instance($orderAddress->getShippingAddress());
        } else {
            $payment->setShipping()->setAddress()->instance($orderAddress->getBillingAddress());
        }
        \RakutenPay\Resources\Log\Logger::info('Shipping set.');
        $payment->setBilling()->setAddress()->instance($orderAddress->getBillingAddress());
        \RakutenPay\Resources\Log\Logger::info('Billing set.');
        $payment->setShipping()->setType()->withParameters(SHIPPING_TYPE);
        \RakutenPay\Resources\Log\Logger::info('Shipping type set.');
        $payment->setShipping()->setCost()->withParameters(number_format($this->order->getShippingAmount(), 2, '.',
            ''));
        \RakutenPay\Resources\Log\Logger::info('Shipping costs set.');
        $payment->setNotificationUrl($this->getNotificationURL());
        \RakutenPay\Resources\Log\Logger::info('Callback URL set.');
        $payment->setSender()->setGender($this->order->getCustomerGender());
        \RakutenPay\Resources\Log\Logger::info('Gender set.');
        $payment->setSender()->setBirthdate($this->order->getCustomerDob());
        \RakutenPay\Resources\Log\Logger::info('DOB set.');
        \RakutenPay\Resources\Log\Logger::info('All info set, returning.');
        return $payment;
    }

    /**
     * @param \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard $payment
     */
    private function setItems($payment)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing setItems.');
        foreach ($this->order->getAllVisibleItems() as $product) {
            $payment->addItems()->withParameters(
                'SKU' . $product->getSku(),
                $product->getProduct()->getId(),
                substr($product->getName(), 0, 254),
                (float)$product->getQtyOrdered(),
                number_format((float)$product->getPrice(), 2, '.', ''),
                round($product->getWeight())
            );
        }
    }

    private function getNotificationURL()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getNotificationURL.');
        $notificationPath = Mage::getStoreConfig('payment/rakutenpay/notification');

        if ($notificationPath) {
            $notificationUrl = $notificationPath;
        } else {
            $notificationUrl = Mage::app()->getStore(0)->getBaseUrl().'rakutenpay/notification/send/';
        }

        return $notificationUrl;
    }

   /**
    * Get the direct payment method (boleto or credit card)
    * and instantiate the respective payment object
    * @param string $paymentMethod
    * @param array $paymentData
    * @return \RakutenPay\Domains\Requests\DirectPayment\Boleto
    *           || \RakutenPay\Domains\Requests\DirectPayment\CreditCard $payment
    */
    public function paymentDirect($paymentMethod, $paymentData)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing payment for ' . $paymentMethod);
        $payment = null;

        switch ($paymentMethod) {
            case 'rakutenpay_boleto':
                $formatedDocument = $this->helper->formatDocument($paymentData['boletoDocument']);
                $payment = new \RakutenPay\Domains\Requests\DirectPayment\Boleto();
                $payment->setFingerprint($paymentData['fingerprint']);
                $payment->setSender()->setDocument()->withParameters(
                    $formatedDocument['type'],
                    $formatedDocument['number']
                );
                $payment->setSender()->setHash($paymentData['boletoHash']);
                break;

            case 'rakutenpay_credit_card':
                $formatedDocument = $this->helper->formatDocument($paymentData['creditCardDocument']);

                $payment = new \RakutenPay\Domains\Requests\DirectPayment\CreditCard();
                $payment->setFingerprint($paymentData['fingerprint']);
                $payment->setToken($paymentData['creditCardToken']);
                $payment->setCvv($paymentData['creditCardCode']);
                $payment->setBrand($paymentData['creditCardBrand']);
                $payment
                ->setInstallment()
                ->withParameters(
                    $paymentData['creditCardInstallment'],
                    number_format($paymentData['creditCardInstallmentValue'], 2, '.', ''),
                    null,
                    number_format($paymentData['creditCardInterestPercent'], 2, '.', ''),
                    number_format($paymentData['creditCardInterestAmount'], 2, '.', ''),
                    number_format($paymentData['creditCardInstallmentTotalValue'], 2, '.', '')
                );
                $payment->setHolder()->setBirthdate($paymentData['creditCardBirthdate']);
                $payment->setHolder()->setName($paymentData['creditCardHolder']);
                $payment->setHolder()->setDocument()->withParameters(
                    $formatedDocument['type'],
                    $formatedDocument['number']
                );
                $payment->setSender()->setDocument()->withParameters(
                    $formatedDocument['type'],
                    $formatedDocument['number']
                );
                $orderAddress = new Rakuten_RakutenPay_Model_OrderAddress($this->order);
                $payment->setSender()->setHash($paymentData['creditCardHash']);
                break;
        }

        /** @var \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard $payment */
        \RakutenPay\Resources\Log\Logger::info('Processing done.');
        return $this->payment($payment);
    }

    /**
     * @param \RakutenPay\Domains\Requests\DirectPayment\Boleto|\RakutenPay\Domains\Requests\DirectPayment\CreditCard|\RakutenPay\Domains\Requests\Payment $payment
     *
     * @param bool $code
     *
     * @return bool|\RakutenPay\Domains\Requests\DirectPayment\Boleto $response
     */
    public function paymentRegister($payment, $code = false)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing paymentRegister.');
        $response = false;
        try {
            if ($code) {
                /** @var \RakutenPay\Domains\Requests\Payment $response */
                $response = $payment->register($this->library->getAccountCredentials(), true)->getCode();
            } else {
                /** @var \RakutenPay\Domains\Requests\DirectPayment\Boleto $payment */
                $response = $payment->register($this->library->getAccountCredentials());
            }
        } catch (Exception $exception) {
            \RakutenPay\Resources\Log\Logger::error($exception);
            Mage::logException($exception);
        }

        return $response;
    }

    /**
     * @param Mage_Sales_Model_Order $order
     *
     * @return Mage_Sales_Model_Order
     */
    public function setOrder(Mage_Sales_Model_Order $order)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing setOrder.');
        return $this->order = $order;
    }

    /**
     * getter for $_session (must be public to be instatiated in blocks)
     * @return type
     */
    public function getSession()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getSession.');
        if (is_null($this->_session) || empty($this->_session)) {
            $this->_session = $this->getPaymentSession()->getResult();
        }
        return $this->_session;
    }
}
