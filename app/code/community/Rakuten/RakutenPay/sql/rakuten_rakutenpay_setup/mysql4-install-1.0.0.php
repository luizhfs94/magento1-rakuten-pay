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
$installer->startSetup();

// table prefix
$tp = (string)Mage::getConfig()->getTablePrefix();
$table = $tp . "sales_order_status";

// Verifies that no record of the status RakutenPay created, if you have not created
$sql .= "INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'aguardando_pagamento_rp' AS STATUS, 'Aguardando Pagamento' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'aguardando_pagamento_rp') = 0;

         INSERT INTO " . $table ." (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'em_analise_rp' AS STATUS, 'Em análise' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'em_analise_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'paga_rp' AS STATUS, 'Paga' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'paga_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'disponivel_rp' AS STATUS, 'Disponível' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'disponivel_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'em_disputa_rp' AS STATUS, 'Em Disputa' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'em_disputa_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'devolvida_rp' AS STATUS, 'Devolvida' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'devolvida_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'cancelada_rp' AS STATUS, 'Cancelada' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'cancelada_rp') = 0;";

$table = $tp . "sales_order_status_state";

// Verifies that no record of the status RakutenPay to be displayed on a new order if it has not created
$sql .= "INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'devolvida_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'devolvida_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'cancelada_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'cancelada_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'em_disputa_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'em_disputa_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'disponivel_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'disponivel_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'paga_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'paga_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'em_analise_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'em_analise_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'aguardando_pagamento_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'aguardando_pagamento_rp') = 0;";

$installer->run($sql);

$new_table =  $tp . 'rakutenpay_orders';

// Checks for the rakutenpay_orders table if it does not exist is created
$sql = "CREATE TABLE IF NOT EXISTS `" . $new_table . "` (
         `entity_id` int(11) NOT NULL AUTO_INCREMENT,
         `order_id` int(11),
         `transaction_code` varchar(80) NOT NULL,
         `sent` int DEFAULT 0,
         `environment` varchar(40),
         PRIMARY KEY (`entity_id`)
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$table = $tp . "sales_order_status";

// Verifies that no record of the status RakutenPay created, if you have not created
$sql .= "INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'chargeback_debitado_rp' AS STATUS, 'Chargeback Debitado' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'chargeback_debitado_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'em_contestacao_rp' AS STATUS, 'Em Contestação' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'em_contestacao_rp') = 0;";

$table = $tp . "sales_order_status_state";

// Verifies that no record of the status RakutenPay to be displayed on a new order if it has not created
$sql .= "INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'chargeback_debitado_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'chargeback_debitado_rp') = 0;

         INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'em_contestacao_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'em_contestacao_rp') = 0;";

$table = $tp . "sales_order_status";

$sql .= "INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'chargeback_parcial_debitado_rp' AS STATUS, 'Chargeback Parcial Debitado' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'chargeback_parcial_debitado_rp') = 0;";

$table = $tp . "sales_order_status_state";

// Verifies that no record of the status RakutenPay to be displayed on a new order if it has not created
$sql .= "INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'chargeback_parcial_debitado_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'chargeback_parcial_debitado_rp') = 0;";

$table = $tp . "sales_order_status";

$sql .= "INSERT INTO `" . $table . "` (STATUS, label)
         SELECT p.status, p.label FROM(SELECT 'chargeback_parcial_debitado_rp' AS STATUS, 'Chargeback Parcial Debitado' AS label) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'chargeback_parcial_debitado_rp') = 0;";

$table = $tp . "sales_order_status_state";

// Verifies that no record of the status RakutenPay to be displayed on a new order if it has not created
$sql .= "INSERT INTO `" . $table . "` (STATUS, state, is_default)
         SELECT p.status, p.state, p.is_default FROM
         (SELECT 'chargeback_parcial_debitado_rp' AS STATUS, 'new' AS state, '0' AS is_default) p
         WHERE (SELECT COUNT(STATUS) FROM `" . $table . "` WHERE STATUS = 'chargeback_parcial_debitado_rp') = 0;";

$installer->run($sql);
$installer->endSetup();
