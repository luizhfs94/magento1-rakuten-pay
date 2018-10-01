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

class Rakuten_RakutenPay_Block_Sales_Order_Rakutenfee extends Mage_Core_Block_Template
{
    public function initTotals()
    {
        $order = $this->getParentBlock()->getOrder();

        if ((float) $order->getBaseRakutenfeeAmount())
        {
            $source = $this->getParentBlock()->getSource();
            $value = $source->getRakutenfeeAmount();
            $this->getParentBlock()->addTotal(new Varien_Object(array(
                'code'   => 'rakutenfee',
                'strong' => false,
                'label'  => 'Taxa de Juros',
                'value'  => $value
            )));
        }
        
        return $this;
    }
}