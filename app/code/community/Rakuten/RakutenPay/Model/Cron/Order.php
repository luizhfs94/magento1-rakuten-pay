<?php
/**
 ************************************************************************
 * Copyright [2018] [RakutenConnector]
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
 * Class Rakuten_RakutenPay_Model_Cron_Order
 */
class Rakuten_RakutenPay_Model_Cron_Order
{

    /**
     * @return array
     */
    protected function getFilterStatus()
    {
        return [
//            \Rakuten\Connector\Enum\DirectPayment\Status::APPROVED,
//            \Rakuten\Connector\Enum\DirectPayment\Status::CANCELLED,
            \Rakuten\Connector\Enum\DirectPayment\Status::PARTIAL_REFUNDED,
            \Rakuten\Connector\Enum\DirectPayment\Status::REFUNDED
        ];
    }

    public function updateOrderStatus()
    {
        \Rakuten\Connector\Resources\Log\Logger::info("hhhhhh");
        $orderCollection = Mage::getModel('sales/order')->getCollection()
            ->addFieldToFilter('status', ['nin' => $this->getFilterStatus()]);

        \Rakuten\Connector\Resources\Log\Logger::info(count($orderCollection));
        foreach ($orderCollection as $order) {
            $addtionalInformation = $order->getPayment()->getAdditionalInformation();
            if (isset($addtionalInformation[ 'rakutenpay_id'])) {
                \Rakuten\Connector\Resources\Log\Logger::info($addtionalInformation['rakutenpay_id']);
            }
        }
//        // For all Orders to analyze
//        foreach($collection as $orderByPayment){
//            $order = $orderByPayment;
//            $paymentOrder = $order->getPayment();
//            $infoPayments = $paymentOrder->getAdditionalInformation();
//            if (isset($infoPayments['merchant_order_id']) && $order->getStatus() !== 'complete') {
//                $merchantOrderId =  $infoPayments['merchant_order_id'];
//                $response = Mage::getModel('mercadopago/core')->getMerchantOrder($merchantOrderId);
//                if ($response['status'] == 201 || $response['status'] == 200) {
//                    $merchantOrderData = $response['response'];
//                    $paymentData = $this->_statusHelper->getDataPayments($merchantOrderData, self::LOG_FILE);
//                    $statusFinal = $this->_statusHelper->getStatusFinal($paymentData['status'], $merchantOrderData);
//                    $statusDetail = $infoPayments['status_detail'];
//                    $statusOrder = $this->_statusHelper->getStatusOrder($statusFinal, $statusDetail);
//                    if (isset($statusOrder) && ($order->getStatus() !== $statusOrder)) {
//                        $this->_updateOrder($order, $statusOrder, $paymentOrder);
//                    }
//                } else{
//                    $helper->log('Error updating status order using cron whit the merchantOrder num: '. $merchantOrderId .'mercadopago.log');
//                }
//            }
//        }
    }

    protected function _updateOrder($order, $statusOrder, $paymentOrder){
        $order->setState($this->_statusHelper->_getAssignedState($statusOrder));
        $order->addStatusToHistory($statusOrder, $this->_statusHelper->getMessage($statusOrder, $statusOrder), true);
        $order->sendOrderUpdateEmail(true, $this->_statusHelper->getMessage($statusOrder, $paymentOrder));
        $order->save();
    }

    protected function getDataPayments($merchantOrderData)
    {
        $data = array();
        foreach ($merchantOrderData['payments'] as $payment) {
            $data = $this->getFormattedPaymentData($payment['id'], $data);
        }
        return $data;
    }

    protected function getFormattedPaymentData($paymentId, $data = array())
    {
        $core = Mage::getModel('mercadopago/core');
        $response = $core->getPayment($paymentId);
        if ($response['status'] == 400 || $response['status'] == 401) {
            return array();
        }
        $payment = $response['response']['collection'];
//        return $this->_statusHelper->formatArrayPayment($data, $payment, self::LOG_FILE);
    }
}