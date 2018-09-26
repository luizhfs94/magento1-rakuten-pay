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


class Rakuten_RakutenLogistics_Block_Adminhtml_InvoiceData_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', 
                    array('order_increment_id' => $this->getRequest()->getParam('order_increment_id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        $fieldset = $form->addFieldset('invoice_data_form', array('legend'=>'Invoice information'));
        $fieldset->addField('order_invoice_serie', 'text', 
            array(
                'label' => 'Series',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'order_invoice_serie',
            )
        );
        $fieldset->addField('order_invoice_number', 'text', 
            array(
                'label' => 'Number',
                'required' => false,
                'name' => 'order_invoice_number',
            )
        );
        $fieldset->addField('order_invoice_key', 'text', 
            array(
                'label' => 'Key',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'order_invoice_key',
            )
        );
        $fieldset->addField('order_invoice_cfop', 'text', 
            array(
                'label' => 'Cfop',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'order_invoice_cfop',
            )
        );
        $fieldset->addField('order_invoice_date', 'date', 
            array(
                'label' => 'Date',
                'class' => 'validate-date validate-date-range date-range-attribute-to required-entry',
                'required' => true,
                'name' => 'order_invoice_date',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
                'format' =>  Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                'time' => false,
       
            )
        );
        $fieldset->addField('order_invoice_value_base_icms', 'text', 
            array(
                'label' => 'Value Base ICMS',
                'class' => 'validate-number',
                'required' => false,
                'name' => 'order_invoice_value_base_icms',
            )
        );
        $fieldset->addField('order_invoice_value_icms', 'text', 
            array(
                'label' => 'Value ICMS',
                'class' => 'validate-number',
                'required' => false,
                'name' => 'order_invoice_value_icms',
            )
        );
        $fieldset->addField('order_invoice_value_base_icms_st', 'text', 
            array(
                'label' => 'Value Base ICMS ST',
                'class' => 'validate-number',
                'required' => false,
                'name' => 'order_invoice_value_base_icms_st',
            )
        );
        $fieldset->addField('order_invoice_value_icms_st', 'text', 
            array(
                'label' => 'Value ICMS ST',
                'class' => 'validate-number',
                'required' => false,
                'name' => 'order_invoice_value_icms_st',
            )
        );
        
        if ( Mage::getSingleton('adminhtml/session')->getOrderData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getOrderData());
            Mage::getSingleton('adminhtml/session')->getOrderData(null);
        } elseif ( Mage::registry('order_data') ) {
            $form->setValues(Mage::registry('order_data')->getData());
        }
        return parent::_prepareForm();
    }
    
}