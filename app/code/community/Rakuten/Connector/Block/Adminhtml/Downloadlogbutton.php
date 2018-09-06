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

class Rakuten_Connector_Block_Adminhtml_Downloadlogbutton extends Mage_Adminhtml_Block_System_Config_Form_Field {
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);

        $url = Mage::helper("adminhtml")->getUrl('connector/adminhtml_log/download');

        $html = $this
            ->getLayout()
            ->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setLabel('Download')
            ->setId('payment_connector_log_download')
            ->setOnClick("setLocation('$url')")
            ->toHtml();

        return $html;
    }
}
