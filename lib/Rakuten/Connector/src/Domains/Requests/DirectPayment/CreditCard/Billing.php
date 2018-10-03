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

namespace Rakuten\Connector\Domains\Requests\DirectPayment\CreditCard;

use Rakuten\Connector\Helpers\InitializeObject;

/**
 * Trait Billing
 * @package Rakuten\Connector\Domains\Requests\DirectPayment\CreditCard
 */
trait Billing
{
    private $billing;

    /**
     *
     * @return \Rakuten\Connector\Domains\Requests\Adapter\DirectPayment\Billing
     */
    public function setBilling()
    {
        $this->billing = InitializeObject::initialize(
            $this->billing,
            '\Rakuten\Connector\Domains\DirectPayment\CreditCard\Billing'
        );
        return new \Rakuten\Connector\Domains\Requests\Adapter\DirectPayment\Billing($this->billing);
    }
    
    /**
     *
     * @return billing
     */
    public function getBilling()
    {
        return $this->billing;
    }
}
