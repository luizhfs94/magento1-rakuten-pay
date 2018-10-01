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

namespace Rakuten\Connector\Resources\Factory\Request\DirectPayment\CreditCard\Holder;

use Rakuten\Connector\Enum\Properties\Current;

/**
 * Class Document
 * @package Rakuten\Connector\Resources\Factory\Request\DirectPayment\CreditCard\Holder
 */
class Document
{

    /**
     * @var \Rakuten\Connector\Domains\Document
     */
    private $holder;

    /**
     * Document constructor.
     */
    public function __construct($holder)
    {
        $this->holder = $holder;
    }

    /**
     * @param \Rakuten\Connector\Domains\Document $document
     * @return \Rakuten\Connector\Domains\DirectPayment\CreditCard\Holder
     */
    public function instance(\Rakuten\Connector\Domains\Document $document)
    {
        $this->holder->setDocuments($document);
        return $this->holder;
    }

    /**
     * @param $array
     * @return \Rakuten\Connector\Domains\DirectPayment\CreditCard\Holder
     */
    public function withArray($array)
    {
        $properties = new Current;
        $document = new \Rakuten\Connector\Domains\Document();
        $document->setType($array[$properties::DOCUMENT_TYPE])
                 ->setIdentifier($array[$properties::DOCUMENT_VALUE]);
        $this->holder->setDocuments($document);
        return $this->holder;
    }

    /**
     * @param $type
     * @param $identifier
     * @return \Rakuten\Connector\Domains\DirectPayment\CreditCard\Holder
     */
    public function withParameters($type, $identifier)
    {
        $document = new \Rakuten\Connector\Domains\Document();
        $document->setType($type)
                 ->setIdentifier($identifier);
        $this->holder->setDocuments($document);
        return $this->holder;
    }
}
