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

namespace RakutenPay\Resources;

use RakutenPay\Enum\Http\Status;
use RakutenPay\Resources\Responsibility\Configuration\Environment;
use RakutenPay\Resources\Responsibility\Configuration\Extensible;
use RakutenPay\Resources\Responsibility\Configuration\File;
use RakutenPay\Resources\Responsibility\Configuration\Wrapper;

/**
 * class Handler
 * @package RakutenPay\Services\Connection\Responsibility
 */
class Responsibility
{
    public static function http($http, $class)
    {
        switch ($http->getStatus()) {
            case Status::OK:
                return $class::success($http);
            case Status::BAD_REQUEST:
                $error = $class::error($http);
                throw new \Exception($error->getMessage(), $error->getCode());
            case Status::UNAUTHORIZED:
                $error = $class::error($http);
                throw new \Exception($error->getMessage(), $error->getCode());
            case Status::UNPROCESSABLE:
                $error = $class::error($http);
                throw new \Exception($error->getMessage(), $error->getCode());
            case Status::BAD_GATEWAY:
                $error = $class::error($http);
                throw new \Exception($error->getMessage(), $error->getCode());
            default:
                unset($class);
                throw new \ErrorException($http->getResponse(), $http->getStatus());
        }
    }

    public static function configuration()
    {
        $environment = new Environment;
        $extensible = new Extensible;
        $file = new File;
        $wrapper = new Wrapper;

        $wrapper->successor(
            $environment->successor(
                $file->successor(
                    $extensible
                )
            )
        );
        return $wrapper->handler(null, null);
    }
}
