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

namespace Rakuten\Connector\Enum;

/**
 * Class Mask
 * @package Rakuten\Connector\Enum
 */
class Mask extends Enum
{
    /**
     * Mask for CPF
     */
    const CPF = "999.***.***-**";

    /**
     * Mask for RG
     */
    const RG = "99.999.***-**";

    /**
     * Mask for Birth Date
     */
    const BIRTH_DATE = "**/**/9999";

    /**
     * Mask for Phone
     */
    const PHONE = "(**) 9999-****";

    /**
     * Mask for Mobile
     */
    const MOBILE = "(**) 99999-****";
}
