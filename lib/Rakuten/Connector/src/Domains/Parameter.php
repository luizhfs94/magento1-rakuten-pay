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

namespace Rakuten\Connector\Domains;

/**
 * Class Parameter
 * @package Rakuten\Connector\Domains
 */
class Parameter
{
    /**
     * Allow add extra information to order
     *
     * @var string
     */
    private $key;

    /**
     * Value of corresponding key
     *
     * @var mixed
     */
    private $value;

    /**
     * Used for the index of values of parameter
     * @var mixed
     */
    private $index;

    /**
     * Gets the parameter item key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Gets parameter item value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets parameter item value
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Gets parameter index
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Sets parameter item group
     *
     * @param int $group
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = (int) $index;
        return $this;
    }
}
