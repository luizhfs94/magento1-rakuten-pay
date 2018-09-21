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

namespace RakutenConnector\Parsers;

use Mage;
use RakutenConnector\Resources\Log\Logger;

/**
 * Trait Order
 * @package RakutenConnector\Parsers
 */
trait Order
{
    /**
     * @param $request
     * @param $properties
     * @return array
     */
    public static function getData($request, $properties)
    {
        Logger::info('Processing getData in trait Order.');
        $data = [];
        $order_data = [];

        if (!is_null($request->getShipping()) and !is_null($request->getShipping()->getCost())) {
            $shipping_cost = floatval(\RakutenConnector\Helpers\Currency::toDecimal($request->getShipping()->getCost()->getCost()));
        }

        $items = self::getItems($request, $properties);
        $items_amount = 0.0;
        foreach ($items as $item) {
            if (!is_null($item[$properties::TOTAL_AMOUNT])) {
                $items_amount += $item[$properties::TOTAL_AMOUNT];
            }
        }

        $taxes_amount = 0.0;
        if (method_exists($request, 'getInstallment') and !is_null(current($request->getInstallment())) and !is_null(current($request->getInstallment())->getInterestAmount())) {
            $taxes_amount = floatval(current($request->getInstallment())->getInterestAmount());
        }

        //items_amount
        $order_data[$properties::ITEMS_AMOUNT] = $items_amount;
        //shipping_amount
        $order_data[$properties::SHIPPING_AMOUNT] = $shipping_cost;
        //taxes_amount
        $order_data[$properties::TAXES_AMOUNT] = $taxes_amount;
        //discount_amount
        $order_data[$properties::DISCOUNT_AMOUNT] = 0.0;
        //items
        $order_data[$properties::ITEMS] = $items;
        //remote_ip
        $order_data[$properties::PAYER_IP] = \Mage::helper('core/http')->getRemoteAddr();
        //reference
        $order_data[$properties::REFERENCE] = $request->getReference();
        $data[$properties::ORDER] = $order_data;
        return $data;
    }

    private static function getItems($request, $properties)
    {
        $items_data = [];
        $items = $request->getItems();
        if ($request->itemLenght() > 0) {
            foreach ($items as $item) {
                $items_data[] = self::getItem($item, $properties);
            }
        }
        return $items_data;
    }

    private static function getItem($item, $properties)
    {
        $data = [];
        $quantity = null;
        $amount = null;
        //reference
        if ($item->getId() != null) {
            $data[$properties::REFERENCE] = $item->getId();
            $product = Mage::getModel('catalog/product')->load($item->getReference());
        }
        //description
        if ($item->getDescription() != null) {
            $data[$properties::DESCRIPTION] = $item->getDescription();
        }
        //amount
        if ($item->getAmount() != null) {
            $amount = floatval(\RakutenConnector\Helpers\Currency::toDecimal($item->getAmount()));
            $data[$properties::AMOUNT] = $amount;
        }
        //quantity
        if ($item->getQuantity() != null) {
            $quantity = $item->getQuantity();
            $data[$properties::QUANTITY] = intval($quantity);
        }
        //total
        if (!is_null($amount) and ! is_null($quantity)) {
            $total = $amount * $quantity;
            $data[$properties::TOTAL_AMOUNT] = $total;
        }

        //categories
        if (!is_null($product) and $product->getCategoryIds() != null) {
            $categories = [];
            $category_ids = $product->getCategoryIds();
            foreach ($category_ids as $category_id) {
                $_cat = Mage::getModel('catalog/category')->setStoreId(Mage::app()->getStore()->getId())->load($category_id);
                $category = [];
                $category[$properties::NAME] = $_cat->getName();
                $category[$properties::ID] = $category_id;
                $categories[] = $category;
            }

            $data[$properties::CATEGORIES] = $categories;
        }

        return $data;
    }
}
