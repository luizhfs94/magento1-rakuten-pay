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

/**
 * Class Installment
 * @package Rakuten\Connector\Parsers\Transaction\Checkout
 */
class Installment
{
    private $installmentAmount;

    private $interestAmount;

    private $interestPercent;

    private $quantity;

    private $total;

    public function getInstallmentAmount()
    {
        return $this->installmentAmount;
    }

    public function setInstallmentAmount($installmentAmount)
    {
        $this->installmentAmount = $installmentAmount;
        return $this;
    }

    public function getInterestAmount()
    {
        return $this->interestAmount;
    }

    public function setInterestAmount($interestAmount)
    {
        $this->interestAmount = $interestAmount;
        return $this;
    }

    public function getInterestPercent()
    {
        return $this->interestPercent;
    }

    public function setInterestPercent($interestPercent)
    {
        $this->interestPercent = $interestPercent;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }
}