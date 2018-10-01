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

namespace Rakuten\Connector\Helpers;

use Rakuten\Connector\Resources\Log\Logger;

/**
 * Class Xhr
 * @package Rakuten\Connector\Helpers
 */
class Xhr
{

    /**
     * Validate if the request is a POST http method
     * @return bool
     */
    public static function hasPost()
    {
        Logger::info('Processing hasPost in Xhr.');
        //initialize super global is required
        $post = $_POST;
        return self::validate($post);
    }

    /**
     * Validate if the request is a GET http method
     * @return bool
     */
    public static function hasGet()
    {
        Logger::info('Processing hasGet in Xhr.');
        //initialize super global is required
        $get = $_GET;
        return self::validate($get);
    }

    /**
     * Get input code post value
     * @return integer|null
     */
    public static function getInputCode()
    {
        Logger::info('Processing getInputCode in Xhr.');
        //use filter input instead of super globals for security
        return filter_input(INPUT_POST, 'notificationCode', FILTER_SANITIZE_STRING) !== null ?
            filter_input(INPUT_POST, 'notificationCode', FILTER_SANITIZE_STRING) : null;
    }

    /**
     * Get input type post value
     * @return string|null
     */
    public static function getInputType()
    {
        Logger::info('Processing getInputType in Xhr.');
        //use filter input instead of super globals for security
        return filter_input(INPUT_POST, 'notificationType', FILTER_SANITIZE_STRING) !== null ?
            filter_input(INPUT_POST, 'notificationType', FILTER_SANITIZE_STRING) : null;
    }

    /**
     * Validate if the input is set.
     * @param $input
     * @return bool
     */
    private static function validate($input)
    {
        Logger::info('Processing validate in Xhr.');
        if (isset($input)) {
            return true;
        }
        return false;
    }
}
