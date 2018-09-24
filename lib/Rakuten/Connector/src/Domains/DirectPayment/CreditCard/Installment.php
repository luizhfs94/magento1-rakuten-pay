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

namespace Rakuten\Connector\Domains\DirectPayment\CreditCard;

/**
 * Class Installment
 * @package Rakuten\Connector\Domains\DirectPayment\CreditCard
 */
class Installment
{
    private $quantity;
    private $value;
    private $interestPercent;
    private $interestAmount;
    private $noInterestInstallmentQuantity;
    private $totalValue;

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getInterestPercent()
    {
        return $this->interestPercent;
    }

    public function getInterestAmount()
    {
        return $this->interestAmount;
    }

    public function getNoInterestInstallmentQuantity()
    {
        return $this->noInterestInstallmentQuantity;
    }

    public function getTotalValue()
    {
        return $this->totalValue;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function setInterestPercent($interestPercent)
    {
        $this->interestPercent = $interestPercent;
        return $this;
    }

    public function setInterestAmount($interestAmount)
    {
        $this->interestAmount = $interestAmount;
        return $this;
    }

    public function setNoInterestInstallmentQuantity($noInterestQuantity)
    {
        $this->noInterestInstallmentQuantity = $noInterestQuantity;
        return $this;
    }

    public function setTotalValue($totalValue)
    {
        $this->totalValue = $totalValue;
        return $this;
    }
}
