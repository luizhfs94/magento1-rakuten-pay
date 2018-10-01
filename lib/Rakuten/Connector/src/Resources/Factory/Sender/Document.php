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

namespace Rakuten\Connector\Resources\Factory\Sender;

use Rakuten\Connector\Enum\Properties\Current;

/**
 * Class Document
 * @package Rakuten\Connector\Resources\Factory\Sender
 */
class Document
{

    /**
     * @var \Rakuten\Connector\Domains\Document
     */
    private $sender;

    /**
     * Document constructor.
     */
    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param \Rakuten\Connector\Domains\Document $document
     * @return \Rakuten\Connector\Domains\Document
     */
    public function instance(\Rakuten\Connector\Domains\Document $document)
    {
        $this->sender->setDocuments($document);
        return $this->sender;
    }

    /**
     * @param $array
     * @return \Rakuten\Connector\Domains\Document|Document
     */
    public function withArray($array)
    {
        $properties = new Current;
        $document = new \Rakuten\Connector\Domains\Document();
        $document->setType($array[$properties::DOCUMENT_TYPE])
                 ->setIdentifier($array[$properties::DOCUMENT_VALUE]);
        $this->sender->setDocuments($document);
        return $this->sender;
    }

    /**
     * @param $type
     * @param $identifier
     * @return \Rakuten\Connector\Domains\Document
     */
    public function withParameters($type, $identifier)
    {
        $document = new \Rakuten\Connector\Domains\Document();
        $document->setType($type)
                 ->setIdentifier($identifier);
        $this->sender->setDocuments($document);
        return $this->sender;
    }
}
