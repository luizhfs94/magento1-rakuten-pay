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

namespace RakutenPay\Parsers\DirectPayment\CreditCard;

/**
 * Request from the Credit Card direct payment
 * @package RakutenPay\Parsers\DirectPayment\CreditCard
 */
use RakutenPay\Enum\Properties\Constants;
use RakutenPay\Parsers\Basic;
use RakutenPay\Parsers\Customer;
use RakutenPay\Parsers\Error;
use RakutenPay\Parsers\Order;
use RakutenPay\Parsers\Parser;
use RakutenPay\Resources\RakutenPay\Http;
use RakutenPay\Parsers\Transaction\CreditCard\Response;

/**
 * Class Payment
 * @package RakutenPay\Parsers\DirectPayment\CreditCard
 */
class Request extends Error implements Parser
{
    use Basic;
    use Payment;
    use Customer;
    use Order;

    /**
     * @param \RakutenPay\Domains\Requests\DirectPayment\CreditCard $creditCard
     * @return array
     */
    public static function getData(\RakutenPay\Domains\Requests\DirectPayment\CreditCard $creditCard)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getData in trait Request.');
        $data = [];
        $properties = new Constants();
        return array_merge(
            $data,
            Basic::getData($creditCard, $properties),
            Payment::getData($creditCard, $properties),
            Customer::getData($creditCard, $properties),
            Order::getData($creditCard, $properties)
        );
    }

    /**
     * @param \RakutenPay\Resources\RakutenPay\Http $http
     * @return Response
     */
    public static function success(Http $http)
    {
        \RakutenPay\Resources\Log\Logger::info($http->getResponse(), ["service" => "HTTP_RESPONSE"]);
        $data = json_decode($http->getResponse(), true);

        $charge_url = \RakutenPay\Resources\Builder\DirectPayment\Payment::getRequestUrl() . '/' . $data['charge_uuid'];

        return (new Response)->setResult($data['result'])
                ->setId($data['charge_uuid'])
                ->setCharge($charge_url);
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
