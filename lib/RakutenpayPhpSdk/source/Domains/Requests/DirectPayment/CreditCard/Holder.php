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

namespace RakutenPay\Domains\Requests\DirectPayment\CreditCard;

use RakutenPay\Helpers\InitializeObject;

/**
 * Class Sender
 * @package RakutenPay\Domains\Requests
 */
trait Holder
{
    /**
     * @var
     */
    private $holder;

    /**
     * @return \RakutenPay\Domains\Requests\Adapter\DirectPayment\Holder
     */
    public function setHolder()
    {
        $this->holder = InitializeObject::initialize(
            $this->holder,
            '\RakutenPay\Domains\DirectPayment\CreditCard\Holder'
        );
        return new \RakutenPay\Domains\Requests\Adapter\DirectPayment\Holder($this->holder);
    }

    /**
     * @return \RakutenPay\Domains\DirectPayment\CreditCard\Holder
     */
    public function getHolder()
    {
        return $this->holder;
    }
}