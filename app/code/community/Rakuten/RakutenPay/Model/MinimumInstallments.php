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

class Rakuten_RakutenPay_Model_MinimumInstallments
{
    public function toOptionArray()
    {
        \Rakuten\Connector\Resources\Log\Logger::info('Processing toOptionArray in ModelMinimumInstallment.');
        return array(
            array("value" => 1, "label" => "1"),
            array("value" => 2, "label" => "2"),
            array("value" => 3, "label" => "3"),
            array("value" => 4, "label" => "4"),
            array("value" => 5, "label" => "5"),
            array("value" => 6, "label" => "6"),
            array("value" => 7, "label" => "7"),
            array("value" => 8, "label" => "8"),
            array("value" => 9, "label" => "9"),
            array("value" => 10, "label" => "10"),
            array("value" => 11, "label" => "11"),
            array("value" => 12, "label" => "12")
        );
    }
}