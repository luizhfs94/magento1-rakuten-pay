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

namespace RakutenPay\Domains\Requests\DirectPayment\Boleto;

use RakutenPay\Domains\Requests\BasicData;
use RakutenPay\Domains\Requests\DirectPayment\CreditCard\Billing;
use RakutenPay\Domains\Requests\DirectPayment\Mode;
use RakutenPay\Domains\Requests\DirectPayment\Sender;
use RakutenPay\Domains\Requests\Item;
use RakutenPay\Domains\Requests\Notification;
use RakutenPay\Domains\Requests\ReceiverEmail;
use RakutenPay\Domains\Requests\Redirect;
use RakutenPay\Domains\Requests\Reference;
use RakutenPay\Domains\Requests\Requests;
use RakutenPay\Domains\Requests\Shipping;

/**
 * Class Request
 * @package RakutenPay\Domains\Requests\DirectPayment\OnlineDebit
 */
class Request implements Requests
{
    use BasicData;
    use Billing;
    use Item;
    use Mode;
    use Notification {
        Notification::getUrl as getNotificationUrl;
        Notification::setUrl as setNotificationUrl;
        Notification::getUrl insteadof Redirect;
        Notification::setUrl insteadof Redirect;
    }
    use ReceiverEmail;
    use Sender;
    use Shipping;
    use Reference;
    use Redirect {
        Redirect::getUrl as getRedirectUrl;
        Redirect::setUrl as setRedirectUrl;
    }
}
