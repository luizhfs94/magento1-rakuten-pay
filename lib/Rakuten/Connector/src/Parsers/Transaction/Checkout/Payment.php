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

namespace Rakuten\Connector\Parsers\Transaction\Checkout;

use Rakuten\Connector\Parsers\Transaction\Checkout\Installment;

/**
 * Class Payment
 * @package Rakuten\Connector\Parsers\Transaction\Checkout
 */
class Payment
{
    private $amount;

    private $method;

    private $installments;

    public function getAmount(){
        return $this->amount;
    }

    public function setAmount($amount){
        $this->amount = $amount;
        return $this;
    }

    public function getMethod(){
        return $this->method;
    }

    public function setMethod($method){
        $this->method = $method;
        return $this;
    }

    public function getInstallments()
    {
        return $this->installments;
    }

    public function setInstallments($installments)
    {
        if ($installments){
            if (is_object($installments[0])) {
                self::addInstallments($installments);
            } else {
                foreach($installments as $installment){
                    self::addInstallment($installment);
                }
            }
        }
        return $this;
    }

    public function addInstallments($installments)
    {
        foreach ($installments as $installment) {
            array_push($this->simulation, $installment);
        }
        return;
    }

    public function addInstallment($installment)
    {
        $response = $this->createInstallment($installment);
        $this->installments[] = $response;
        return;
    }

    public function createInstallment($response)
    {
        $installment = new Installment();
        $installment
        ->setInstallmentAmount($response['installment_amount'])
        ->setInterestAmount($response['interest_amount'])
        ->setInterestPercent($response['interest_percent'])
        ->setQuantity($response['quantity'])
        ->setTotal($response['total']);

        return $installment;
    }

}