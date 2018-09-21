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

namespace RakutenConnector\Parsers;

use RakutenConnector\Resources\RakutenPay\Http;

/**
 * Class Error
 * @package RakutenConnector\Parsers
 */
class Error
{
    /**
     * @param \RakutenConnector\Resources\RakutenPay\Http $http
     * @return \RakutenConnector\Domains\Error
     */
    protected static function error(Http $http)
    {
        $error = new \RakutenConnector\Domains\Error;
        $error->setCode($http->getStatus())
              ->setMessage($http->getResponse());
        return $error;
    }
}
