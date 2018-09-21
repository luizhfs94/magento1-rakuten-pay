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

namespace RakutenPay\Parsers\Checkout;

use RakutenPay\Enum\Properties\Current;
use RakutenPay\Parsers\Accepted;
use RakutenPay\Parsers\Basic;
use RakutenPay\Parsers\Currency;
use RakutenPay\Parsers\Error;
use RakutenPay\Parsers\Item;
use RakutenPay\Parsers\Parser;
use RakutenPay\Parsers\PaymentMethod;
use RakutenPay\Parsers\PreApproval;
use RakutenPay\Parsers\Sender;
use RakutenPay\Parsers\Shipping;
use RakutenPay\Parsers\Metadata;
use RakutenPay\Parsers\Parameter;
use RakutenPay\Parsers\ReceiverEmail;
use RakutenPay\Resources\RakutenPay\Http;

/**
 * Class Payment
 * @package RakutenPay\Parsers\Checkout
 */
class Request extends Error implements Parser
{
    use Accepted;
    use Basic;
    use Currency;
    use Item;
    use PreApproval;
    use Sender;
    use Shipping;
    use Metadata;
    use ReceiverEmail;
    use Parameter;
    use PaymentMethod;

    /**
     * @param \RakutenPay\Domains\Requests\Payment $payment
     * @return array
     */
    public static function getData(\RakutenPay\Domains\Requests\Payment $payment)
    {
        $data = [];
        $properties = new Current;
        return array_merge(
            $data,
            Accepted::getData($payment, $properties),
            Basic::getData($payment, $properties),
            Currency::getData($payment, $properties),
            Item::getData($payment, $properties),
            PreApproval::getData($payment, $properties),
            Sender::getData($payment, $properties),
            Shipping::getData($payment, $properties),
            Metadata::getData($payment, $properties),
            Parameter::getData($payment),
            PaymentMethod::getData($payment, $properties),
            ReceiverEmail::getData($payment, $properties)
        );
    }

    /**
     * @param \RakutenPay\Resources\RakutenPay\Http $http
     * @return Response
     */
    public static function success(Http $http)
    {
        $xml = simplexml_load_string($http->getResponse());
        return (new Response)->setCode(current($xml->code))
                             ->setDate(current($xml->date));
    }

    /**
     * @param \RakutenPay\Resources\RakutenPay\Http $http
     * @return \RakutenPay\Domains\Error
     */
    public static function error(Http $http)
    {
        return parent::error($http);
    }
}
