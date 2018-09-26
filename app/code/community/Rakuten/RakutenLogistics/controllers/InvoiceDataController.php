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


class Rakuten_RakutenLogistics_InvoiceDataController extends Mage_Adminhtml_Controller_Action {        
    
    protected function _construct()
    {
        parent::_construct();
    }

    public function editAction()
    {
        \Rakuten\Connector\Resources\Log\Logger::info('Processing editAction in InvoiceDataController.');
        $orderIncrementId = $this->getRequest()->getParam('order_increment_id');  
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
        if ($order->getId()) {
            Mage::register('order_data', $order);
            $this->loadLayout();
            
            $this->_addBreadcrumb(
                'Sales',
                'Invoice Data'
            );
            $this->_addContent($this->getLayout()->createBlock('rakuten_rakutenlogistics/adminhtml_invoiceData_edit'));
                  
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError('Order not found.');
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        \Rakuten\Connector\Resources\Log\Logger::info('Processing saveAction in InvoiceDataController.');
        $orderIncrementId = $this->getRequest()->getParam('order_increment_id');  
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
        if ($order->getId() || $orderIncrementId == 0) {
            $parameters = $this->getRequest()->getParams();
            $order->setOrderInvoiceSerie($parameters['order_invoice_serie']);
            $order->setOrderInvoiceNumber($parameters['order_invoice_number']);
            $order->setOrderInvoiceKey($parameters['order_invoice_key']);
            $order->setOrderInvoiceCfop($parameters['order_invoice_cfop']);
            $order->setOrderInvoiceDate($parameters['order_invoice_date']);
            $order->setOrderInvoiceValueBaseIcms($parameters['order_invoice_value_base_icms']);
            $order->setOrderInvoiceValueIcms($parameters['order_invoice_value_icms']);
            $order->setOrderInvoiceValueBaseIcmsSt($parameters['order_invoice_value_base_icms_st']);
            $order->setOrderInvoiceValueIcmsSt($parameters['order_invoice_value_icms_st']);
            $order->save();
            Mage::getSingleton('adminhtml/session')->addSuccess('Order invoice data saved.');
            $this->_redirect('adminhtml/sales_order/index');
        } else {
            Mage::getSingleton('adminhtml/session')->addError('Order not found.');
            $this->_redirect('*/*/');
        }
    }
}