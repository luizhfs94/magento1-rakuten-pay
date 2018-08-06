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
 * Class Rakuten_RakutenPay_Helper_Webservice
 */
class Rakuten_RakutenPay_Helper_Webservice extends Rakuten_RakutenPay_Helper_Data
{
    /**
     * @var Rakuten_RakutenPay_Model_Library
     */
    private $library;

    /**
     * Rakuten_RakutenPay_Helper_Webservice constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->library = new Rakuten_RakutenPay_Model_Library();
    }

    /**
     * @param $transactionCode
     *
     * @return \RakutenPay\Services\Transactions\Notification
     */
    public function getNotification()
    {
        return \RakutenPay\Services\Transactions\Notification::check();
    }

    /**
     * @param $page
     * @param $maxPageResults
     * @param $initialDate
     *
     * @return null|string
     * @throws Exception
     */
    public function getTransactionsByDate($page, $maxPageResults, $initialDate)
    {
        $response = null;
        try {
            $response = \RakutenPay\Services\Transactions\Search\Date::search(
                array('initial_date' => $initialDate, 'page' => $page, 'max_per_page' => $maxPageResults)
            );
        } catch (Exception $e) {
            if (trim($e->getMessage()) == '[HTTP 401] - UNAUTHORIZED') {
                throw new Exception($e->getMessage());
            }
        }

        return $response;
    }

    /**
     * @param $transactionCode
     *
     * @return \RakutenPay\Services\Transactions\Refund
     */
    public function refundRequest($transactionCode, $refundValue = null, $kind = 'total',
            $reason = 'merchant_other', $bankData = null, $paymentId = null)
    {
        return \RakutenPay\Services\Transactions\Refund::create(
            $transactionCode,
            $refundValue,
            $kind,
            $reason,
            $bankData,
            $paymentId
        );
    }

    /**
     * @param $class
     * @param $transactionCode
     *
     * @return mixed|string
     * @throws Exception
     */
    public function requestRakutenPayService($class, $transactionCode)
    {
        try {
            if ($class == 'Rakuten_RakutenPay_Adminhtml_RefundController') {
                return \RakutenPay\Services\Transactions\Refund::create($transactionCode);
            } elseif ($class == 'Rakuten_RakutenPay_Model_NotificationMethod') {
                return \RakutenPay\Services\Transactions\Notification::check();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
