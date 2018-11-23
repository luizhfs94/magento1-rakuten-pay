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

namespace Rakuten\Connector\Resources\Connection;

/**
 * Class Data
 * @package Rakuten\Connector\Resources\Connection
 */
class Data
{
    use Base\Checkout\Payment;
    use Base\DirectPayment\Payment;
    use Base\Checkout;
    use Base\Notification;
    use Base\Refund;
    use Base\Cancel;
    use Base\Pooling\OrderStatus;
    use Base\Transaction\Search {
        Base\Transaction\Search::buildSearchRequestUrl as buildTransactionSearchRequestUrl;
    }

    /**
     * @param $data
     * @return string
     */
    public function buildHttpUrl($data)
    {
        return http_build_query($data);
    }
}
