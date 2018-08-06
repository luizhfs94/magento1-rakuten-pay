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


$installer = $this;
$installer->startSetup();
function addFeeColumns($installer)
{
    $table = $installer->getTable('sales/quote_address');
    
    $installer->getConnection()
        ->addColumn($table, 'rakutenfee_amount', array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'scale' => 2,
            'precision' => 14,
            'unsigned' => true,
            'nullable' => false,
            'comment' => 'Fee Amount',
        ));
    $installer->getConnection()
        ->addColumn($table, 'base_rakutenfee_amount', array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'scale' => 2,
            'precision' => 14,
            'unsigned' => true,
            'nullable' => false,
            'comment' => 'Base Rakuten Fee Amount',
        ));
    $table = $installer->getTable('sales/order');
    
    $installer->getConnection()
        ->addColumn($table, 'rakutenfee_amount', array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'scale' => 2,
            'precision' => 14,
            'unsigned' => true,
            'nullable' => false,
            'comment' => 'Rakuten Fee Amount',
        ));
    $installer->getConnection()
        ->addColumn($table, 'base_rakutenfee_amount', array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'scale' => 2,
            'precision' => 14,
            'unsigned' => true,
            'nullable' => false,
            'comment' => 'Base Rakuten Fee Amount',
        ));
}

addFeeColumns($installer);
$installer->endSetup();