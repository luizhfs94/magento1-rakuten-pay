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

namespace RakutenConnector\Domains\Requests;

use RakutenConnector\Helpers\InitializeObject;

/**
 * Trait Metadata
 * @package RakutenConnector\Domains\Requests
 */
trait Metadata
{
    private $metadata;
    
    public function addMetadata()
    {
        $this->metadata = InitializeObject::Initialize(
            $this->metadata,
            new \RakutenConnector\Resources\Factory\Request\Metadata()
        );
        
        return $this->metadata;
    }

    public function setMetadata($metadata)
    {
        if (is_array($metadata)) {
            $arr = array();
            foreach ($metadata as $key => $metadataItem) {
                if ($metadataItem instanceof \RakutenConnector\Domains\Metadata) {
                    $arr[$key] = $metadataItem;
                } else {
                    if (is_array($metadata)) {
                        $arr[$key] = new \RakutenConnector\Domains\Metadata($metadataItem);
                    }
                }
            }
            $this->metadata = $arr;
        }
    }

    public function getMetadata()
    {
        return current($this->metadata);
    }

    public function metadataLenght()
    {
        return (! is_null($this->metadata)) ? count(current($this->metadata)) : 0;
    }
}
