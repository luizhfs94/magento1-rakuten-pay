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

namespace RakutenPay\Helpers;

class Characters
{
    /**
     *
     */
    const PATTERN = "/[^a-z0-9]/";

    /**
     * @param $subject
     * @return bool|string
     */
    public static function hasSpecialChars($subject)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing hasSpecialChars in Characters.');
        if (preg_match(self::PATTERN, $subject)) {
            return self::removeSpecialChars($subject);
        }
        return $subject;
    }

    /**
     * @param $subject
     * @return string
     */
    public static function removeSpecialChars($subject)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing removeSpecialChars in Characters.');
        return preg_replace(self::PATTERN, null, $subject);
    }
}
