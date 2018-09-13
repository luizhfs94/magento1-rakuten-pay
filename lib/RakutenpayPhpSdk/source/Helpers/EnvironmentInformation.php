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

use Mage;
use RakutenPay\Resources\Log\Logger;

/**
 * Class EnvironmentInformation
 * Get environment configuration
 *
 * @package RakutenPay\Helpers
 */
class EnvironmentInformation
{
    const PHPINFO_INFO_CONFIGURATION = 'INFO_CONFIGURATION';

    /**
     * @return string
     */
    public static function getPHPVersion()
    {
        $phpVersion = 'Current PHP version: ' . phpversion();

        return $phpVersion;
    }

    /**
     * @return string
     */
    public static function getMagentoVersion()
    {
        $phpVersion = 'Magento Version: ' . Mage::getVersion();

        return $phpVersion;
    }

    /**
     * Record system version on Log
     * @void
     */
    public static function writeLogVersions()
    {
        Logger::info(self::getPHPVersion() . ' - ' . self::getMagentoVersion(), ['service' => 'version']);
    }

    /**
     * Record config php.ini on Log
     *
     * @param null $constant
     * @void
     */
    public static function writeLogPHPConfiguration($constant = null)
    {
        if (is_null($constant)) {
            $constant = self::PHPINFO_INFO_CONFIGURATION;
        }
        $phpInfo = self::phpinfoToArray($constant);
        if (count($phpInfo)) {
            foreach (array_pop($phpInfo) as $key => $info) {
                Logger::info(sprintf('Key: %s => master: %s | local: %s', $key, $info['master'], $info['local']), ['service' => 'php.ini']);
            }
        }
    }

    /**
     * @see http://www.php.net/manual/en/function.phpinfo.php#87463
     *
     * @param null $constant
     * @return array
     */
    private static function phpinfoToArray($constant = null)
    {
        $infoArray = [];
        try {
            ob_start();
            if (is_null($constant)) {
                phpinfo();
            } else {
                phpinfo(constant($constant));
            }
            $infoArray = array();
            $infoLines = explode("\n", strip_tags(ob_get_clean(), "<tr><td><h2>"));
            $cat = "General";
            foreach ($infoLines as $line) {
                // new cat?
                preg_match("~<h2>(.*)</h2>~", $line, $title) ? $cat = $title[1] : null;
                if (preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val)) {
                    $infoArray[$cat][$val[1]] = $val[2];
                } elseif (preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val)) {
                    $infoArray[$cat][$val[1]] = array("local" => $val[2], "master" => $val[3]);
                }
            }

            return $infoArray;
        } catch (\Exception $e) {
            Logger::error('Error in phpinfoToArray in EnvironmentInformation: ' . $e->getMessage());
            return $infoArray;
        }
    }
}