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

use Rakuten\Connector\Resources\Log\Logger;

class Rakuten_RakutenPay_AdminHtml_LogController extends Mage_Adminhtml_Controller_Action
{
    public function _construct()
    {
    }

    public function downloadAction()
    {
        $filepath = Mage::getBaseDir('base') . '/' . Logger::filepath();

        if (Logger::active()) {
            try {
                $this->_prepareDownloadResponse(Logger::filepath(), array('type' => 'filename', 'value' => $filepath));
            } catch (Exception $e) {
                throw $e;
            }
        }
        else {
            return false;
        }
    }
}
