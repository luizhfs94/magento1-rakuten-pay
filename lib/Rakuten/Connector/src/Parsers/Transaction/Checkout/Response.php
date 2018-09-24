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

use Rakuten\Connector\Parsers\Transaction\Checkout\Payment;

/**
 * Class Response
 * @package Rakuten\Connector\Parsers\Transaction\Checkout
 */
class Response
{
    private $result;

    private $payments;

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function getCreditCardPayment()
    {
        foreach($this->payments as $payment){
            if ($payment->getMethod() == 'credit_card'){
                return $payment;
            }
        }
        return new Payment();
    }

    public function setPayments($payments)
    {
        if($payments){
            if (is_object($payment[0])){
                self::addPayments($payments);
            } else {
                foreach($payments as $payment) {
                    self::addPayment($payment);
                }
            }
        }

        return $this;
    }

    public function addPayments($payments)
    {
        foreach($payments as $payment) {
            array_push($this->payment, $payment);
        }
        return;
    }

    public function addPayment($payment)
    {
        $response = $this->createPayment($payment);
        $this->payments[] = $response;
        return;
    }

    public function createPayment($response)
    {
        $payment = new Payment;
        $payment
        ->setMethod($response['method'])
        ->setAmount($response['amount']);

        if($response['method'] == 'credit_card'){
            $payment
            ->setInstallments($response['installments']);
        }

        return $payment;
    }
}