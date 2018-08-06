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

namespace RakutenPay\Domains\Requests\Checkout\Payment;

use RakutenPay\Domains\Requests\BasicData;
use RakutenPay\Domains\Requests\Item;
use RakutenPay\Domains\Requests\Metadata;
use RakutenPay\Domains\Requests\Notification;
use RakutenPay\Domains\Requests\Parameter;
use RakutenPay\Domains\Requests\PaymentMethod;
use RakutenPay\Domains\Requests\PaymentMethod\Accepted;
use RakutenPay\Domains\Requests\PreApproval\PreApproval;
use RakutenPay\Domains\Requests\Requests;
use RakutenPay\Domains\Requests\Review;
use RakutenPay\Domains\Requests\Sender;
use RakutenPay\Domains\Requests\Shipping;
use RakutenPay\Domains\Requests\ReceiverEmail;
use RakutenPay\Domains\Requests\Reference;
use RakutenPay\Domains\Requests\Redirect;

/**
 * Class Request
 * @package RakutenPay\Domains\Requests
 */
class Request implements Requests
{
    use Accepted {
        Accepted::accept as acceptPaymentMethod;
        Accepted::exclude as excludePaymentMethod;
        Accepted::getAttributeMap as acceptedPaymentMethods;
    }
    use BasicData;
    use Item;
    use Metadata;
    use Notification {
        Notification::getUrl as getNotificationUrl;
        Notification::setUrl as setNotificationUrl;
    }
    use Parameter;
    use PaymentMethod;
    use PreApproval;
    use Sender;
    use Shipping;
    use Reference;
    use ReceiverEmail;
    use Redirect {
        Redirect::getUrl as getRedirectUrl;
        Redirect::setUrl as setRedirectUrl;
        Redirect::getUrl insteadof Notification;
        Redirect::setUrl insteadof Notification;
    }
    use Review {
        Review::getUrl as getReviewUrl;
        Review::setUrl as setReviewUrl;
        Review::getUrl insteadof Redirect;
        Review::setUrl insteadof Redirect;
    }
}
