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

namespace Rakuten\Connector\Domains\Requests\Shipping;

/**
 * Trait Type
 * @package Rakuten\Connector\Domains\Requests\Shipping
 */
trait Type
{
    private $type;

    public function getType()
    {
        return current($this->type);
    }

    public function setType()
    {
        $this->type = new \Rakuten\Connector\Resources\Factory\Shipping\Type($this->shipping);
        return $this->type;
    }
}
