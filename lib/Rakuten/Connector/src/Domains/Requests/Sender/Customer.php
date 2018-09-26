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

namespace Rakuten\Connector\Domains\Requests\Sender;

/**
 * Trait Customer
 * @package Rakuten\Connector\Domains\Requests\Sender
 */
trait Customer
{
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->sender->email;
    }

    /**
     * @param mixed $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->sender->setEmail($email);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->sender->name;
    }

    /**
     * @param mixed $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->sender->setName($name);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->sender->gender;
    }

    /**
     * @param mixed $name
     * @return Customer
     */
    public function setGender($gender)
    {
        $this->sender->setGender($gender);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->sender->birthdate;
    }

    /**
     * @param mixed $name
     * @return Customer
     */
    public function setBirthdate($birthdate)
    {
        $this->sender->setBirthdate($birthdate);
        return $this;
    }
}
