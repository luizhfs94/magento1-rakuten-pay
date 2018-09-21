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

namespace RakutenConnector\Resources\Factory\Sender;

use RakutenConnector\Enum\Properties\Current;

/**
 * Class Document
 * @package RakutenConnector\Resources\Factory\Sender
 */
class Document
{

    /**
     * @var \RakutenConnector\Domains\Document
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
     * @param \RakutenConnector\Domains\Document $document
     * @return \RakutenConnector\Domains\Document
     */
    public function instance(\RakutenConnector\Domains\Document $document)
    {
        $this->sender->setDocuments($document);
        return $this->sender;
    }

    /**
     * @param $array
     * @return \RakutenConnector\Domains\Document|Document
     */
    public function withArray($array)
    {
        $properties = new Current;
        $document = new \RakutenConnector\Domains\Document();
        $document->setType($array[$properties::DOCUMENT_TYPE])
                 ->setIdentifier($array[$properties::DOCUMENT_VALUE]);
        $this->sender->setDocuments($document);
        return $this->sender;
    }

    /**
     * @param $type
     * @param $identifier
     * @return \RakutenConnector\Domains\Document
     */
    public function withParameters($type, $identifier)
    {
        $document = new \RakutenConnector\Domains\Document();
        $document->setType($type)
                 ->setIdentifier($identifier);
        $this->sender->setDocuments($document);
        return $this->sender;
    }
}
