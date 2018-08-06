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

namespace RakutenPay\Parsers\Response;

use RakutenPay\Helpers\InitializeObject;

/**
 * Class Item
 * @package RakutenPay\Parsers\Response
 */
trait Item
{

    /**
     * @var
     */
    private $itemCount;
    /**
     * @var
     */
    private $items;

    /**
     * @return mixed
     */
    public function getItemCount()
    {
        return $this->itemCount;
    }

    /**
     * @param $itemCount
     * @return $this
     */
    public function setItemCount($itemCount)
    {
        $this->itemCount = $itemCount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }


    /**
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        foreach ($items->item as $value) {
            $this->addItems()->withParameters(
                current($value->id),
                current($value->description),
                current($value->quantity),
                current($value->amount)
            );
        }

        $this->items = current($this->getItems());
        return $this;
    }

    /**
     * @return object
     */
    public function addItems()
    {
        $this->items = InitializeObject::Initialize(
            $this->items,
            new \RakutenPay\Resources\Factory\Item()
        );
        return $this->items;
    }
}
