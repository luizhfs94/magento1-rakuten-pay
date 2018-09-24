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

namespace Rakuten\Connector\Domains\Requests\Checkout\Payment;

use Rakuten\Connector\Domains\Requests\BasicData;
use Rakuten\Connector\Domains\Requests\Item;
use Rakuten\Connector\Domains\Requests\Metadata;
use Rakuten\Connector\Domains\Requests\Notification;
use Rakuten\Connector\Domains\Requests\Parameter;
use Rakuten\Connector\Domains\Requests\PaymentMethod;
use Rakuten\Connector\Domains\Requests\PaymentMethod\Accepted;
use Rakuten\Connector\Domains\Requests\PreApproval\PreApproval;
use Rakuten\Connector\Domains\Requests\Requests;
use Rakuten\Connector\Domains\Requests\Review;
use Rakuten\Connector\Domains\Requests\Sender;
use Rakuten\Connector\Domains\Requests\Shipping;
use Rakuten\Connector\Domains\Requests\ReceiverEmail;
use Rakuten\Connector\Domains\Requests\Reference;
use Rakuten\Connector\Domains\Requests\Redirect;

/**
 * Class Request
 * @package Rakuten\Connector\Domains\Requests\Checkout\Payment
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
