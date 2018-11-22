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
 * Class Rakuten_RakutenLogistics_Block_Adminhtml_InvoiceData_Edit
 */
class Rakuten_RakutenLogistics_Block_Adminhtml_InvoiceData_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Rakuten_RakutenLogistics_Block_Adminhtml_InvoiceData_Edit constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        $incrementId = $this->getRequest()->getParam('order_increment_id');
        $orderId = $this->getOrderId($incrementId);
        $this->_objectId = 'order_increment_id';
        $this->_blockGroup = 'rakuten_rakutenlogistics';
        $this->_controller = 'adminhtml_invoiceData';
        $this->_mode = 'edit';
        $this->removeButton('back');
        $this->addButton('back', array(
            'label'     => Mage::helper('adminhtml')->__('Back'),
            'onclick'   => 'setLocation(\'' . Mage::helper('adminhtml')->getUrl("adminhtml/sales_order/view", array('order_id' => $orderId)) . '\')',
            'class'     => 'back',
        ), -1);
    }

    /**
     * @param $incrementId
     * @return int
     */
    private function getOrderId($incrementId)
    {
        $order =  Mage::getModel('sales/order')->loadByIncrementId($incrementId);

        return $order->getId();
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        return 'Invoice Data';
    }
}