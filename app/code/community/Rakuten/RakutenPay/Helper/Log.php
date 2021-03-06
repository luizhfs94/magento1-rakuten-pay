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
 * Class Rakuten_RakutenPay_Helper_Log
 */
class Rakuten_RakutenPay_Helper_Log
{
    /**
     * @param $orderId
     * @param $recoveryCode
     */
    public function setAbandonedSendEmailLog($orderId, $recoveryCode)
    {
        $module = 'RakutenPayAbandoned.';
        $phrase = "Mail( SendEmailAbandoned: array (\n 'orderId' => ".$orderId.",\n ";
        $phrase .= "'recoveryCode' => '".$recoveryCode."'\n) )";
        $this->setLog($phrase, $module);
    }

    /**
     * @param $phrase
     * @param $module
     */
    public function setLog($phrase, $module)
    {
        if (Mage::getStoreConfig('payment/rakutenpay/log')) {
            \Rakuten\Connector\Resources\Log\Logger::info($phrase, ['service' => $module]);
        }
    }

    /**
     * @param $orderId
     * @param $sent
     */
    public function setAbandonedSentEmailUpdateLog($orderId, $sent)
    {
        $module = 'RakutenPayAbandoned.';
        $phrase = "SentEmailUpdate( Has been updated to ".$sent." the number of emails sent,";
        $phrase .= " belonging to order ".$orderId." )";
        $this->setLog($phrase, $module);
    }

    public function setRequirementsLog()
    {
        $module = 'RakutenPayRequirements.';
        $phrase = "Verification ( Checked requirements )";
        $this->setLog($phrase, $module);
    }

    /**
     * @param $class
     * @param $days
     */
    public function setSearchTransactionLog($class, $days)
    {
        $now = new \DateTime("now");
        $initial = new \DateTime("now");
        $initial->sub(new \DateInterval('P' . $days . 'D'));
        $phrase = "Search( '".$days." days - Range of dates ";
        $phrase .= $initial->format('Y-m-d')." until ".$now->format('Y-m-d')."' )";
        $this->setLog($phrase, $this->setModule($class));
    }

    /**
     * @param $class
     *
     * @return null|string
     */
    private function setModule($class)
    {
        $module = null;
        $option = explode('_', $class);
        $module = 'RakutenPay'.end($option).'.';

        return $module;
    }

    /**
     * @param $class
     * @param $orderId
     * @param $transactionCode
     * @param $orderStatus
     */
    public function setUpdateOrderLog($class, $orderId, $transactionCode, $orderStatus)
    {
        $phrase = "Update( OrderStatusMagento: array (\n 'orderId' => ".$orderId.",\n ";
        $phrase .= "'transactionCode' => '".$transactionCode."',\n ";
        $phrase .= "'orderStatus' => '".$orderStatus."'\n ) )";
        $this->setLog($phrase, $this->setModule($class));
    }
}
