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

namespace Rakuten\Connector\Parsers\Checkout;

use Rakuten\Connector\Enum\Properties\Current;
use Rakuten\Connector\Parsers\Accepted;
use Rakuten\Connector\Parsers\Basic;
use Rakuten\Connector\Parsers\Currency;
use Rakuten\Connector\Parsers\Error;
use Rakuten\Connector\Parsers\Item;
use Rakuten\Connector\Parsers\Parser;
use Rakuten\Connector\Parsers\PaymentMethod;
use Rakuten\Connector\Parsers\PreApproval;
use Rakuten\Connector\Parsers\Sender;
use Rakuten\Connector\Parsers\Shipping;
use Rakuten\Connector\Parsers\Metadata;
use Rakuten\Connector\Parsers\Parameter;
use Rakuten\Connector\Parsers\ReceiverEmail;
use Rakuten\Connector\Resources\RakutenPay\Http;

/**
 * Class Request
 * @package Rakuten\Connector\Parsers\Checkout
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
     * @param \Rakuten\Connector\Domains\Requests\Payment $payment
     * @return array
     */
    public static function getData(\Rakuten\Connector\Domains\Requests\Payment $payment)
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
     * @param \Rakuten\Connector\Resources\RakutenPay\Http $http
     * @return Response
     */
    public static function success(Http $http)
    {
        $xml = simplexml_load_string($http->getResponse());
        return (new Response)->setCode(current($xml->code))
                             ->setDate(current($xml->date));
    }

    /**
     * @param \Rakuten\Connector\Resources\RakutenPay\Http $http
     * @return \Rakuten\Connector\Domains\Error
     */
    public static function error(Http $http)
    {
        return parent::error($http);
    }
}
