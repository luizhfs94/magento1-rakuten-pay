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
 * Class StringFormat
 * @package Rakuten\Connector\Helpers
 */
class StringFormat
{
    /***
     * Remove all non digit character from string
     * @param string $value
     * @return string
     */
    public static function getOnlyNumbers($value)
    {
        Logger::info('Processing getOnlyNumbers in StringFormat.');
        return preg_replace('/\D/', '', $value);
    }
    
    /***
     * Return formatted string to send in RakutenPay request
     * @param string $string
     * @param int $limit
     * @param mixed $endchars
     * @return string
     */
    public static function formatString($string, $limit, $endchars = '...')
    {
        Logger::info('Processing formatString in StringFormat.');
        $string = self::removeStringExtraSpaces($string);
        return self::truncateValue($string, $limit, $endchars);
    }
    
    /***
     * Remove left, right and inside extra spaces in string
     * @param string $string
     * @return string
     */
    public static function removeStringExtraSpaces($string)
    {
        Logger::info('Processing removeStringExtraSpaces in StringFormat.');
        return trim(preg_replace("/( +)/", " ", $string));
    }
    
    /***
     * Perform truncate of string value
     * @param string $string
     * @param int $limit
     * @param mixed $endchars
     * @return string
     */
    public static function truncateValue($string, $limit, $endchars = '...')
    {
        Logger::info('Processing truncateValue in StringFormat.');
        if (!is_array($string) && !is_object($string)) {
            $stringLength = strlen($string);
            $endcharsLength = strlen($endchars);

            if ($stringLength > (int) $limit) {
                $cut = (int) ($limit - $endcharsLength);
                $string = substr($string, 0, $cut) . $endchars;
            }
        }
        return $string;
    }
}
