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

/**
 * Admin Charset Options
 */
class Rakuten_RakutenPay_Model_Values
{
    /**
     * Displays the settings to choose charset
     *
     * @return array - Returns the available charsets
     */
    public function toOptionArray()
    {
        \Rakuten\Connector\Resources\Log\Logger::info('Processing toOptionArray in ModelValues.');
        self::alertRequeriments();
        $helper = Mage::helper('rakutenpay');

        return array(
            array("value" => "UTF-8", "label" => $helper->__("UTF-8")),
            array("value" => "ISO-8859-1", "label" => $helper->__("ISO-8859-1")),
        );
    }

    /**
     * Alert the requiriement invalid, of cURL, version of PHP, SPL or DOM.
     */
    public function alertRequeriments()
    {
        \Rakuten\Connector\Resources\Log\Logger::info('Processing alertRequeriments in ModelValues.');
        $requirements = \Rakuten\Connector\Library::validate();
        if (!$requirements) {
            $message = $helper = Mage::helper('rakutenpay')->__("Requerimentos para o sistema funcionar:".$requirements);
            Mage::getSingleton('core/session')->addError($message);
        }
    }
}
