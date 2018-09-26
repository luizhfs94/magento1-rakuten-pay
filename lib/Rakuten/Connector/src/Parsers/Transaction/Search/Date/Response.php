<?php
/**
 ************************************************************************
 * Copyright [2017] [RakutenConnector]
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

namespace Rakuten\Connector\Parsers\Transaction\Search\Date;

use Mage;

/**
 * Class Response
 * @package Rakuten\Connector\Parsers\Transaction\Search\Date
 */
class Response
{
    /**
     * @var
     */
    private $date;
    /**
     * @var
     */
    private $resultsInThisPage;
    /**
     * @var
     */
    private $transactions;
    /**
     * @var
     */
    private $currentPage;
    /**
     * @var
     */
    private $totalPages;

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param mixed $currentPage
     * @return Response
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Response
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResultsInThisPage()
    {
        return $this->resultsInThisPage;
    }

    /**
     * @param mixed $resultsInThisPage
     * @return Response
     */
    public function setResultsInThisPage($resultsInThisPage)
    {
        $this->resultsInThisPage = $resultsInThisPage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * @param mixed $totalPages
     * @return Response
     */
    public function setTotalPages($totalPages)
    {
        $this->totalPages = $totalPages;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param mixed $transactions
     * @return Response
     */
    public function setTransactions($transactions)
    {
        if ($transactions) {
            if (is_object($transactions[0])) {
                self::addTransactions($transactions, true);
            } else {
                foreach ($transactions as $transaction) {
                    self::addTransactions($transaction, false);
                }
            }
        }
        return $this;
    }

    /**
     * @param $transaction
     */
    public function addTransactions($transaction, $just_push = true)
    {
        //check if is an array of transactions if is just push to array
        if ($just_push) {
            foreach ($transaction as $item) {
                array_push($this->transactions, $item);
            }
            return;
        }
        //create a new transaction and push to array
        $response = $this->createTransaction($transaction);
        $this->transactions[] = $response;
        return;
    }

    private function createTransaction($response)
    {
        $helper = Mage::helper('rakutenpay');
        $history = $response['status_history'];
        $payment = $response['payments'][0];
        $transaction = new Transaction();
        $transaction->setDate($response['created_at'])
            ->setCode($response['uuid'])
            ->setReference($helper->getOrderIdFromReference($response['reference']))
            ->setStatus($response['status'])
            ->setLastEventDate(end($history)['created_at'])
            ->setPaymentMethod($payment['method'])
            ->setGrossAmount($payment['amount'])
            ->setNetAmount($payment['refundable_amount'])
            ->setPaymentId($payment['id']);
        return $transaction;
    }
}

