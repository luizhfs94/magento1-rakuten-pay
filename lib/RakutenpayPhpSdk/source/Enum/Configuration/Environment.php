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

namespace RakutenPay\Enum\Configuration;

use RakutenPay\Enum\Enum;

class Environment extends Enum
{
    //Environment
    const ENV = "RAKUTENPAY_ENV";

    //Credentials
    const EMAIL = "RAKUTENPAY_EMAIL";
    const TOKEN_PRODUCTION = "RAKUTENPAY_TOKEN_PRODUCTION";
    const TOKEN_SANDBOX = "RAKUTENPAY_TOKEN_SANDBOX";
    const APP_ID_PRODUCTION = "RAKUTENPAY_APP_ID_PRODUCTION";
    const APP_ID_SANDBOX = "RAKUTENPAY_APP_ID_SANDBOX";
    const APP_KEY_PRODUCTION = "RAKUTENPAY_APP_KEY_PRODUCTION";
    const APP_KEY_SANDBOX = "RAKUTENPAY_APP_KEY_SANDBOX";

    //Encoding
    const CHARSET = "RAKUTENPAY_CHARSET";

    //Log
    const LOG_ACTIVE = "RAKUTENPAY_LOG_ACTIVE";
    const LOG_LOCATION = "RAKUTENPAY_LOG_LOCATION";
}
