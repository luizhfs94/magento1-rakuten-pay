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

namespace Rakuten\Connector\Domains\Requests;

use Rakuten\Connector\Helpers\InitializeObject;

/**
 * Trait Item
 * @package Rakuten\Connector\Domains\Requests
 */
trait Item
{
    private $items;

    public function addItems()
    {
        $this->items = InitializeObject::Initialize(
            $this->items,
            new \Rakuten\Connector\Resources\Factory\Item()
        );
        
        return $this->items;
    }

    public function setItems($items)
    {
        if (is_array($items)) {
            $arr = array();
            foreach ($items as $key => $item) {
                if ($item instanceof \Rakuten\Connector\Domains\Item) {
                    $arr[$key] = $item;
                } else {
                    if (is_array($item)) {
                        $arr[$key] = new \Rakuten\Connector\Domains\Item($item);
                    }
                }
            }
            $this->items = $arr;
        }
    }

    public function getItems()
    {
        return current($this->items);
    }

    public function itemLenght()
    {
        return count(current($this->items));
    }
}
