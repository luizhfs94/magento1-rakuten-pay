<?php
/**
 ************************************************************************
 * Copyright [2017] [RakutenConnector]
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

namespace RakutenConnector\Domains\Requests\DirectPayment\CreditCard;

use RakutenConnector\Domains\Requests\BasicData;
use RakutenConnector\Domains\Requests\DirectPayment\CreditCard\Billing;
use RakutenConnector\Domains\Requests\DirectPayment\CreditCard\Holder;
use RakutenConnector\Domains\Requests\DirectPayment\Mode;
use RakutenConnector\Domains\Requests\DirectPayment\Sender;
use RakutenConnector\Domains\Requests\Item;
use RakutenConnector\Domains\Requests\Notification;
use RakutenConnector\Domains\Requests\ReceiverEmail;
use RakutenConnector\Domains\Requests\Redirect;
use RakutenConnector\Domains\Requests\Reference;
use RakutenConnector\Domains\Requests\Requests;
use RakutenConnector\Domains\Requests\Shipping;

/**
 * Class Request
 * @package RakutenConnector\Domains\Requests\DirectPayment\CreditCard
 */
class Request implements Requests
{
    use Billing;
    use BasicData;
    use Installment;
    use Holder;
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
    use CreditCard;
}
