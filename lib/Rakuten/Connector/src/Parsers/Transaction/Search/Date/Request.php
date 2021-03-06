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

namespace Rakuten\Connector\Parsers\Transaction\Search\Date;

use Rakuten\Connector\Parsers\Error;
use Rakuten\Connector\Parsers\Parser;
use Rakuten\Connector\Parsers\Transaction\Search\Date\Response;
use Rakuten\Connector\Resources\Http\RakutenPay\Http;

/**
 * Class Request
 * @package Rakuten\Connector\Parsers\Transaction\Search\Date
 */
class Request extends Error implements Parser
{

    /**
     * @param \Rakuten\Connector\Resources\Http\RakutenPay\Http $http
     * @return Response
     */
    public static function success(Http $http)
    {
        $json = json_decode($http->getResponse(), true);

        $count = $json['pagination']['total_count'];
        if ($count > $json['pagination']['per_page']) {
            $count = $json['pagination']['per_page'];
        }

        $response = new Response();
        $response->setDate((new \DateTime("now"))->format('Y-m-d'))
            ->setTransactions($json['charges'])
            ->setResultsInThisPage($count)
            ->setCurrentPage($json['pagination']['page'])
            ->setTotalPages($json['pagination']['page_count']);
        return $response;
    }

    /**
     * @param \Rakuten\Connector\Resources\Http\RakutenPay\Http $http
     * @return \RakutenPay\Domains\Error
     */
    public static function error(Http $http)
    {
        $error = parent::error($http);
        return $error;
    }
}
