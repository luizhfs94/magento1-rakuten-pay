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

namespace RakutenConnector\Domains\Requests\Checkout\Payment;

use RakutenConnector\Domains\Requests\BasicData;
use RakutenConnector\Domains\Requests\Item;
use RakutenConnector\Domains\Requests\Metadata;
use RakutenConnector\Domains\Requests\Notification;
use RakutenConnector\Domains\Requests\Parameter;
use RakutenConnector\Domains\Requests\PaymentMethod;
use RakutenConnector\Domains\Requests\PaymentMethod\Accepted;
use RakutenConnector\Domains\Requests\PreApproval\PreApproval;
use RakutenConnector\Domains\Requests\Requests;
use RakutenConnector\Domains\Requests\Review;
use RakutenConnector\Domains\Requests\Sender;
use RakutenConnector\Domains\Requests\Shipping;
use RakutenConnector\Domains\Requests\ReceiverEmail;
use RakutenConnector\Domains\Requests\Reference;
use RakutenConnector\Domains\Requests\Redirect;

/**
 * Class Request
 * @package RakutenConnector\Domains\Requests\Checkout\Payment
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
