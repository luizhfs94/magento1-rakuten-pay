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

namespace RakutenConnector\Parsers\Response;

use RakutenConnector\Resources\Factory\Shipping\Address;
use RakutenConnector\Resources\Factory\Shipping\Cost;
use RakutenConnector\Resources\Factory\Shipping\Type;

/**
 * Trait Shipping
 * @package RakutenConnector\Parsers\Response
 */
trait Shipping
{

    /**
     * @var
     */
    private $shipping;

    /**
     * @return mixed
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param mixed $shipping
     * @return Response
     */
    public function setShipping($shipping)
    {
        $shippingClass = new \RakutenConnector\Domains\Shipping();

        $shippingAddress = new Address($shippingClass);

        $shippingAddress->withParameters(
            current($shipping->address->street),
            current($shipping->address->number),
            current($shipping->address->district),
            current($shipping->address->postalCode),
            current($shipping->address->city),
            current($shipping->address->state),
            current($shipping->address->country),
            current($shipping->address->phone),
            current($shipping->address->complement)
        );

        $shippingType = new Type($shippingClass);
        $shippingType->withParameters(current($shipping->type));

        $shippingCost = new Cost($shippingClass);
        $shippingCost->withParameters(current($shipping->cost));

        $this->shipping = $shippingClass;
        return $this;
    }
}
