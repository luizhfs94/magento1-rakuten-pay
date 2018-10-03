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

namespace Rakuten\Connector\Resources\Factory\Request\DirectPayment\CreditCard;

/**
 * Class Installment
 * @package Rakuten\Connector\Resources\Factory\Request\DirectPayment\CreditCard
 */
class Installment
{
    private $installment;
    
    public function __construct()
    {
        $this->installment = [];
    }
    
    public function instance(\Rakuten\Connector\Domains\DirectPayment\CreditCard\Installment $installment)
    {
        return $installment;
    }
    
    public function withArray($array)
    {
        $installment = new \Rakuten\Connector\Domains\DirectPayment\CreditCard\Installment();
        $installment
        ->setQuantity($array['quantity'])
        ->setValue($array['value']);

        if (isset($array['no_interest_installment_quantity'])) {
            $installment->setNoInterestInstallmentQuantity($array['no_interest_installment_quantity']);
        }

        if (isset($array['interest_percent'])) {
            $installment->setInterestPercent($array['interest_percent']);
        }

        if (isset($array['interest_amount'])) {
            $installment->setInterestAmount($array['interest_amount']);
        }

        if (isset($array['total_value'])) {
            $installment->setTotalValue($array['total_value']);
        }

        $this->installment = $installment;
        return $this->installment;
    }
    
    public function withParameters($quantity, $value, $noInterestInstallmentQuantity = null, $interestPercent = null, $interestAmount = null, $totalValue = null)
    {
        $installment = new \Rakuten\Connector\Domains\DirectPayment\CreditCard\Installment();
        $installment
        ->setQuantity($quantity)
        ->setValue($value);

        if ($noInterestInstallmentQuantity) {
            $installment->setNoInterestInstallmentQuantity($noInterestInstallmentQuantity);
        }

        if ($interestPercent) {
            $installment->setInterestPercent($interestPercent);
        }

        if ($interestAmount) {
            $installment->setInterestAmount($interestAmount);
        }

        if ($totalValue) {
            $installment->setTotalValue($totalValue);
        }

        $this->installment = $installment;

        return $this->installment;
    }
}
