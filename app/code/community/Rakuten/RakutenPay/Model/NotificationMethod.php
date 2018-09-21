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

use Mage_Payment_Model_Method_Abstract as MethodAbstract;

class Rakuten_RakutenPay_Model_NotificationMethod extends MethodAbstract
{
    private $helper;
    private $webhookReference;
    private $webhookStatus;
    private $amount;
    private $post;

    /**
     * Construct
     */
    public function __construct()
    {
        \RakutenConnector\Resources\Log\Logger::info('Constructing ModelNotificationMethod.');
        $this->helper = Mage::helper('rakutenpay');
    }

    public function initialize($post, $state)
    {
        \RakutenConnector\Resources\Log\Logger::info("Initializing the notification model.", ['service' => 'WEBHOOK']);
        $this->post = json_decode($post, true);
        $this->getNotificationPost();
        $this->setNotificationUpdateOrder();
    }

    private function getNotificationPost()
    {
        \RakutenConnector\Resources\Log\Logger::info('Processing getNotificationPost in ModelNotificationMethod.');
        $this->webhookStatus = $this->post['status'];
        $this->webhookReference = $this->post['reference'];
        if ($this->webhookStatus == 'approved') {
            $this->amount = $this->post['amount'];
        } else if($this->webhookStatus == 'partial_refunded' || $this->webhookStatus == 'refunded') {
            $this->amount = -array_sum(array_column($this->post['refunds'], 'amount'));
        } else {
            $this->amount = false;
        }
    }


    private function setNotificationUpdateOrder()
    {
        \RakutenConnector\Resources\Log\Logger::info('Processing setNotificationUpdateOrder in ModelNotificationMethod.');
        $orderId = $this->helper->getOrderIdFromReference($this->webhookReference);
        $transactionCode = $this->webhookStatus;
        $orderStatus = $this->helper->getPaymentStatusFromKey($transactionCode);
        \RakutenConnector\Resources\Log\Logger::info("Processing webhook with transaction: " . $orderId
                    . "; Status: ". $orderStatus . "; Amount: " . $this->amount,
                    ['service' => 'WEBHOOK']);
        if ($orderStatus == false) {
            \RakutenConnector\Resources\Log\Logger::error("Cannot process webhook with transaction: " . $transactionCode,
                    ['service' => 'WEBHOOK']);
            return;
        }
        $class = null;
        $this->helper->updateOrderStatusMagento($class, $orderId, $transactionCode, $orderStatus, $this->amount);
    }
}
