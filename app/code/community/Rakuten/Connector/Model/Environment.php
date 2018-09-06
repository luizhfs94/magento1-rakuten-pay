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

class Rakuten_Connector_Model_Environment
{
    const ENVIRONMENT_SANDBOX = 'sandbox';
    const ENVIRONMENT_PRODUCTION = 'production';

    const LABEL_SANDBOX = 'Sandbox';
    const LABEL_PRODUCTION = 'Production';

    /**
     * Options de environment of module
     * @return array - Returns an array of the available options
     */
    public function toOptionArray()
    {
        return [
            ["value" => self::ENVIRONMENT_PRODUCTION, "label" => self::LABEL_PRODUCTION],
            ["value" => self::ENVIRONMENT_SANDBOX, "label" => self::LABEL_SANDBOX],
        ];
    }
}
