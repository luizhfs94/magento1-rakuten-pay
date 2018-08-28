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

/**
 * Class ModuleCheck
 * @package RakutenPay\Helpers
 */
class ModuleCheck
{
    /**
     * @param $moduleName
     * @return bool
     */
    public static function isModuleInstalled($moduleName)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing isModuleInstalled in ModuleCheck.');
        return Mage::helper('core')->isModuleEnabled($moduleName);
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public static function isEnable($moduleName)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing isEnable in ModuleCheck.');
        return Mage::helper('core')->isModuleOutputEnabled($moduleName);
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public static function isModuleReady($moduleName)
    {
        return self::isModuleInstalled($moduleName) === self::isEnable($moduleName);
    }
}