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

namespace Rakuten\Connector\Domains\PaymentMethod;

/**
 * Class Accepted
 * @package Rakuten\Connector\Domains\PaymentMethod
 */
class Accepted
{
    /**
     * @var
     */
    private $groups;
    /**
     * @var
     */
    private $names;

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     * @return Accepted
     */
    public function setGroups($groups)
    {
        $this->groups[] = $groups;
        return $this;
    }

    /**
     * @return array
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param mixed $names
     * @return Accepted
     */
    public function setNames($names)
    {
        $this->names[] = $names;
        return $this;
    }
}
