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

namespace Rakuten\Connector\Parsers;

use Rakuten\Connector\Domains\Requests\Requests;
use Rakuten\Connector\Resources\Log\Logger;

/**
 * Trait PreApproval
 * @package Rakuten\Connector\Parsers
 */
trait PreApproval
{

    /**
     * @param Requests $request
     * @param $properties
     * @return array
     */
    public static function getData(Requests $request, $properties)
    {
        Logger::info('Processing getData in trait PreApproval.');
        $data = [];
        if (!is_null($request->getPreApproval())) {
            if (!is_null($request->getPreApproval()->getCharge())) {
                $data[$properties::PRE_APPROVAL_CHARGE] = $request->getPreApproval()->getCharge();
            }
            if (!is_null($request->getPreApproval()->getName())) {
                $data[$properties::PRE_APPROVAL_NAME] = $request->getPreApproval()->getName();
            }
            if (!is_null($request->getPreApproval()->getDetails())) {
                $data[$properties::PRE_APPROVAL_DETAILS] =
                    $request->getPreApproval()->getDetails();
            }
            if (!is_null($request->getPreApproval()->getAmountPerPayment())) {
                $data[$properties::PRE_APPROVAL_AMOUNT_PER_PAYMENT] =
                    $request->getPreApproval()->getAmountPerPayment();
            }
            if (!is_null($request->getPreApproval()->getMaxAmountPerPayment())) {
                $data[$properties::PRE_APPROVAL_MAX_AMOUNT_PER_PAYMENT] =
                    $request->getPreApproval()->getMaxAmountPerPayment();
            }
            if (!is_null($request->getPreApproval()->getPeriod())) {
                $data[$properties::PRE_APPROVAL_PERIOD] = $request->getPreApproval()->getPeriod();
            }
            if (!is_null($request->getPreApproval()->getMaxPaymentsPerPeriod())) {
                $data[$properties::PRE_APPROVAL_MAX_PAYMENTS_PER_PERIOD] =
                    $request->getPreApproval()->getMaxPaymentsPerPeriod();
            }
            if (!is_null($request->getPreApproval()->getMaxAmountPerPeriod())) {
                $data[$properties::PRE_APPROVAL_MAX_AMOUNT_PER_PERIOD] =
                    $request->getPreApproval()->getMaxAmountPerPeriod();
            }
            if (!is_null($request->getPreApproval()->getInitialDate())) {
                $data[$properties::PRE_APPROVAL_INITIAL_DATE] =
                    $request->getPreApproval()->getInitialDate();
            }
            if (!is_null($request->getPreApproval()->getFinalDate())) {
                $data[$properties::PRE_APPROVAL_FINAL_DATE] =
                    $request->getPreApproval()->getFinalDate();
            }
            if (!is_null($request->getPreApproval()->getMaxTotalAmount())) {
                $data[$properties::PRE_APPROVAL_MAX_TOTAL_AMOUNT] =
                    $request->getPreApproval()->getMaxTotalAmount();
            }
        }
        return $data;
    }
}
