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

class Rakuten_RakutenPay_Model_Environment
{
    /**
     * Options de environment of module
     * @return array - Returns an array of the available options
     */
    public function toOptionArray()
    {
        \RakutenConnector\Resources\Log\Logger::info('Processing toOptionArray in ModelEnvironment.');
        $helper = Mage::helper('rakutenpay');

        return array(array("value" => "production", "label" => $helper->__("Produção")),
                     array("value" => "sandbox", "label" => $helper->__("Sandbox ")));
    }
}
