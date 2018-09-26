<?php
 
/**
 ************************************************************************
 * Copyright [2018] [RakutenLogistics]
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

class Rakuten_RakutenLogistics_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid 
{
    protected function _prepareColumns()
    {

        $this->addColumnAfter('calculation_code', array(
            'header'    =>  'Label',
            'width'     =>  '30',
            'index'     =>  'calculation_code',
            'type'      =>  'text',
            'renderer'  =>  'Rakuten_RakutenLogistics_Block_Adminhtml_Sales_Order_LabelUrlRenderer',
            'filter'    =>  false
        ), 'status');

        $this->addColumnAfter('invoice_data', array(
            'header'    =>  'Invoice<br>Data',
            'width'     =>  '30',
            'index'     =>  'invoice_data',
            'type'      =>  'text',
            'renderer'  =>  'Rakuten_RakutenLogistics_Block_Adminhtml_Sales_Order_InvoiceDataRenderer',
            'filter'    =>  false
        ), 'calculation_code');
 
 
        return parent::_prepareColumns();
    }

}