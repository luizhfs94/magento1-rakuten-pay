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

namespace RakutenPay\Helpers;

/**
 * Class JsonFormat
 * With helper functions to Json encode and format
 *
 * @package RakutenPay\Helpers
 */
class JsonFormat
{
    /**
     * Json encode and Check if const exists based from PHP Version
     *
     * @param array $data
     * @return mixed|string
     */
    public static function getJson(array $data)
    {
        if (defined('JSON_PRESERVE_ZERO_FRACTION')) {

            return  json_encode($data, JSON_PRESERVE_ZERO_FRACTION);
        }

        /** For PHP Version < 5.6 */
        return self::preserveZeroFractionInstallments($data);
    }

    /**
     * @param array $data
     * @return mixed|string
     */
    private static function preserveZeroFractionInstallments(array $data)
    {
        $jsonData = json_encode($data);
        $payments = $data['payments'];
        foreach ($payments as $key => $item) {
            $jsonData = self::getNewInstallments($item['installments'], $jsonData);
        }

        return $jsonData;
    }

    /**
     * @param array $installments
     * @param $jsonData
     * @return mixed|string
     */
    private static function getNewInstallments(array $installments, $jsonData)
    {
        $interestPercent = $installments['interest_percent'];
        $interestAmount = $installments['interest_amount'];
        $installmentAmount = $installments['installment_amount'];
        $total = $installments['total'];

        $jsonData = str_replace('"interest_percent":'. $interestPercent, '"interest_percent":'. number_format($interestPercent, 2) . '', $jsonData);
        $jsonData = str_replace('"interest_amount":' . $interestAmount, '"interest_amount":'. number_format($interestAmount, 2) . '', $jsonData);
        $jsonData = str_replace('"installment_amount":' . $installmentAmount, '"installment_amount":'. number_format($installmentAmount, 2) . '', $jsonData);
        $jsonData = str_replace('"total":' . $total, '"total":'. number_format($total, 2) . '', $jsonData);

        return $jsonData;
    }
}
