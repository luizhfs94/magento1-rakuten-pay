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

namespace Rakuten\Connector\Domains\Requests\Adapter\DirectPayment;

use Rakuten\Connector\Domains\Requests\DirectPayment\CreditCard\Holder\Document;
use Rakuten\Connector\Domains\Requests\DirectPayment\CreditCard\Holder\Phone;

/**
 * Class Holder
 * @package Rakuten\Connector\Domains\Requests\Adapter\DirectPayment
 */
class Holder
{
    use Document;
    use Phone;

    private $holder;

    /**
     * Holder constructor.
     * @param $holder
     */
    public function __construct($holder)
    {
        $this->holder = $holder;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->holder->getBirthDate();
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthDate($birthdate)
    {
        $this->holder->setBirthDate($birthdate);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->holder->getName();
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->holder->setName($name);
    }
}
