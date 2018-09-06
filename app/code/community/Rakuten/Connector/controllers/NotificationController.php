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

class Rakuten_Connector_NotificationController extends Mage_Core_Controller_Front_Action
{
    /**
     * Notification Action
     */
    public function sendAction()
    {
        \RakutenPay\Resources\Log\Logger::info("Received webhook call.", ['service' => 'WEBHOOK']);
        $entity_headers = null;
        if (!function_exists('apache_request_headers')) {
            \RakutenPay\Resources\Log\Logger::info("We ain't got the (apache_request_headers) method...", ['service' => 'WEBHOOK']);
            $headers = [];
            foreach ($_SERVER as $name => $value)
            {
                if (substr($name, 0, 5) == 'HTTP_')
                {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            $entity_headers = $headers;
        } else {
            $entity_headers = apache_request_headers();
        }
        \RakutenPay\Resources\Log\Logger::info("Got all headers.", ['service' => 'WEBHOOK']);
        $entity_body = file_get_contents('php://input');
        \RakutenPay\Resources\Log\Logger::info("Got the contents.", ['service' => 'WEBHOOK']);
        $sig_key = \Mage::getStoreConfig('payment/rakutenpay/signature_key');
        \RakutenPay\Resources\Log\Logger::info("Got the sig key.", ['service' => 'WEBHOOK']);
        $signature = hash_hmac('sha256', $entity_body, $sig_key, true);
        \RakutenPay\Resources\Log\Logger::info("Calculated the signature.", ['service' => 'WEBHOOK']);
        $signature_base64 = base64_encode($signature);
        \RakutenPay\Resources\Log\Logger::info("Encoded the signature.", ['service' => 'WEBHOOK']);
        if (empty($entity_body)) {
            \RakutenPay\Resources\Log\Logger::info("Empty entity body.", ['service' => 'WEBHOOK']);
            return;
        }
        if (!array_key_exists('Signature', $entity_headers) || $entity_headers['Signature'] !== $signature_base64) {
            \RakutenPay\Resources\Log\Logger::info("Signature does not match.", ['service' => 'WEBHOOK']);
            throw new \Exception("Signature does not match...");
        }
        \RakutenPay\Resources\Log\Logger::info("All OK, processing.", ['service' => 'WEBHOOK']);
        $helper = Mage::helper('connector');
        \RakutenPay\Resources\Log\Logger::info("Created helper.", ['service' => 'WEBHOOK']);
        $helper->notificationModel()->initialize($entity_body, $entity_headers);
    }
}
