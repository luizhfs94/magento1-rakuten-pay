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

namespace RakutenPay\Domains;

/**
 * Class Document
 * @package RakutenPay\Domains
 */
class Document
{
    /**
     * @var
     */
    private $type;
    /**
     * @var
     */
    private $identifier;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return Document
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Document
     */
    public function setType($type)
    {
        $this->type = strtoupper($type);
        return $this;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return sprintf(
            "Document[ Type : %s , Identifier: %s ]",
            $this->getType(),
            $this->getIdentifier()
        );
    }
}