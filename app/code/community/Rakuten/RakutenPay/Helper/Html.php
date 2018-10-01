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

use Rakuten_RakutenPay_Helper_Data as HelperData;

class Rakuten_RakutenPay_Helper_Html extends HelperData
{
    /**
     * Get html of header of backend
     *
     * @return string $html - Html of header
     */
    public function getHeader()
    {
        $logo = Mage::getBaseUrl('skin').'adminhtml/default/default/rakuten/rakutenpay/images/logo.png';
        $version = $this->__('Versão %s', $this->getVersion());
        $html = '<div id="rakutenpay-module-header">
                    <div class="wrapper">
                        <div id="rakutenpay-logo">
                            <img class="rakutenpay_logo" src="'.$logo.'" />
                            <div id="rakutenpay-module-version">'.$version.'</div>
                        </div>
                    </div>
                </div>';

        return $html;
    }
}
