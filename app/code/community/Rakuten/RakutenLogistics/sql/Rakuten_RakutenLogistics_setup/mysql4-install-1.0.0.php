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

$installer = $this;
$setup = new Mage_Catalog_Model_Resource_Setup('core_setup');
$installer->startSetup();   

$heightAttr = array (
    'type' => 'decimal',
    'group' => 'General',
    'input' => 'text',
    'label' => 'Height',
    'required' => true,
    'user_defined' => true,
    'default' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true
);
$setup->addAttribute('catalog_product','height',$heightAttr);

$widthAttr = array (
    'type' => 'decimal',
    'group' => 'General',
    'input' => 'text',
    'label' => 'Width',
    'required' => true,
    'user_defined' => true,
    'default' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true
);
$setup->addAttribute('catalog_product','width',$widthAttr);

$lengthAttr = array (
    'type' => 'decimal',
    'group' => 'General',
    'input' => 'text',
    'label' => 'Length',
    'required' => true,
    'user_defined' => true,
    'default' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true
);
$setup->addAttribute('catalog_product','length',$lengthAttr);


$setup = new Mage_Sales_Model_Mysql4_Setup;

$orderCalculationCode = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Calculation Code',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 1
);

$setup->addAttribute('order', 'calculation_code', $orderCalculationCode);

$orderLabelUrl = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Batch Label Url',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'batch_label_url', $orderLabelUrl);

$orderInvoiceSerie = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Order Invoice Serie',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_serie', $orderInvoiceSerie);

$orderInvoiceNumber = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Order Invoice Number',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_number', $orderInvoiceNumber);

$orderInvoiceKey = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Order Invoice Key',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_key', $orderInvoiceKey);

$orderInvoiceCfop = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Order Invoice Cfop',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_cfop', $orderInvoiceCfop);

$orderInvoiceDate = array(
    'type' => 'date',
    'input' => 'text',
    'label' => 'Order Invoice Date',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_date', $orderInvoiceDate);

$orderInvoiceValueBaseICMS = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Order Invoice Value Base ICMS',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_value_base_icms', $orderInvoiceValueBaseICMS);

$orderInvoiceValueICMS = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Order Invoice Value ICMS',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_value_icms', $orderInvoiceValueICMS);

$orderInvoiceValueBaseICMSST = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Order Invoice Value Base ICMSST',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_value_base_icms_st', $orderInvoiceValueBaseICMSST);

$orderInvoiceValueICMSST = array(
    'type' => 'text',
    'input' => 'text',
    'label' => 'Order Invoice Value ICMSST',
    'required' => false,
    'user_defined' => true,
    'unique' => false,
    'global' => '1',
    'visible' => true,
    'comparable' => true,
    'position'  => 2
);

$setup->addAttribute('order', 'order_invoice_value_icms_st', $orderInvoiceValueICMSST);

$installer->endSetup();