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

namespace RakutenPay\Resources\Log;

use RakutenPay\Helpers\EnvironmentInformation;

/**
 * Class Environment
 * @package RakutenPay\Resources\Log
 */
class Environment extends EnvironmentInformation
{
    /**
     * Record system version on Log
     * @void
     */
    public static function infoVersions()
    {
        Logger::info(sprintf('Current PHP Version: %s - Magento Version: %s - RakutenPay Version: %s',
            self::getPHPVersion(), self::getMagentoVersion(), self::getModuleVersion()), ['service' => 'versions']);
    }

    /**
     * Record config php.ini on Log
     *
     * @param null $constant
     * @void
     */
    public static function infoPHPConfiguration($constant = null)
    {
        if (is_null($constant)) {
            $constant = self::PHPINFO_INFO_CONFIGURATION;
        }
        $phpInfo = self::phpinfoToArray($constant);
        if (count($phpInfo)) {
            foreach (array_pop($phpInfo) as $key => $info) {
                if (array_key_exists('master', $info) && array_key_exists('local', $info)) {
                    Logger::info(sprintf('Key: %s => master: %s | local: %s', $key, $info['master'], $info['local']), ['service' => 'php.ini']);
                }
            }
        }
    }
}