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

namespace Rakuten\Connector\Resources\Factory;

use Rakuten\Connector\Enum\Properties\Current;

/**
 * Class Item
 * @package Rakuten\Connector\Resources\Factory
 */
class Item
{
    /**
     * @var array
     */
    private $item;

    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->item = [];
    }

    /**
     * @param \Rakuten\Connector\Domains\Item $item
     * @return \Rakuten\Connector\Domains\Item
     */
    public function instance(\Rakuten\Connector\Domains\Item $item)
    {
        return $item;
    }

    /**
     * @param $array
     * @return array
     */
    public function withArray($array)
    {
        $properties = new Current;

        $item = new \Rakuten\Connector\Domains\Item();
        $item->setId($array[$properties::ITEM_ID])
             ->setReference($array[$properties::ITEM_REFERENCE])
             ->setAmount($array[$properties::ITEM_AMOUNT])
             ->setDescription($array[$properties::ITEM_DESCRIPTION])
             ->setQuantity($array[$properties::ITEM_QUANTITY])
             ->setWeight($array[$properties::ITEM_WEIGHT])
             ->setShippingCost($array[$properties::ITEM_SHIPPING_COST]);

        array_push($this->item, $item);
        return $this->item;
    }

    /**
     * @param $id
     * @param $description
     * @param $quantity
     * @param $amount
     * @param null $weight
     * @param null $shippingCost
     * @return array
     */
    public function withParameters(
        $id,
        $reference,
        $description,
        $quantity,
        $amount,
        $weight = null,
        $shippingCost = null
    ) {
        $item = new \Rakuten\Connector\Domains\Item();
        $item->setId($id)
            ->setAmount($amount)
            ->setDescription($description)
            ->setQuantity($quantity)
            ->setWeight($weight)
            ->setShippingCost($shippingCost)
            ->setReference($reference);
        array_push($this->item, $item);
        return $this->item;
    }
}
