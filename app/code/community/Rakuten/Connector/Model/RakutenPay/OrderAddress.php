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

/**
 * Class Rakuten_Connector_Model_RakutenPay_OrderAddress
 */
class Rakuten_Connector_Model_RakutenPay_OrderAddress
{
    /**
     * @var Mage_Sales_Model_Order_Address
     */
    private $billingAddress;
    /**
     * @var Mage_Sales_Model_Order
     */
    private $order;
    /**
     * @var Mage_Sales_Model_Order_Address
     */
    private $shippingAddress;

    /**
     * Rakuten_Connector_Model_RakutenPay_OrderAddress constructor.
     * @param Mage_Sales_Model_Order $order
     */
    public function __construct(Mage_Sales_Model_Order $order)
    {
        \RakutenPay\Resources\Log\Logger::info('Constructing ModelOrderAddress.');
        $this->order = $order;
        $this->billingAddress = $this->order->getBillingAddress();
        $this->shippingAddress = $this->order->getShippingAddress();
    }

    /**
     * @return \RakutenPay\Domains\Address
     */
    public function getBillingAddress()
    {
        return $this->setAddress($this->billingAddress);
    }

    /**
     * @param Mage_Sales_Model_Order_Address $address
     *
     * @return \RakutenPay\Domains\Address
     */
    private function setAddress(Mage_Sales_Model_Order_Address $address)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing setAddress in ModelOrderAddress.');
        $name = '';
        if ($address->getFirstname()) {
            $name .= $address->getFirstname();
        }
        if ($address->getMiddlename()) {
            $name .= ' ' . $address->getMiddlename();
        }
        if ($address->getLastname()) {
            $name .= ' ' . $address->getLastname();
        }
        $response = new \RakutenPay\Domains\Address();
        $parse = $this->parseStreet($address->getStreet1());
        $response->setName($name);
        $response->setStreet($parse['street']);
        $response->setNumber($parse['number']);
        $response->setDistrict($address->getStreet2());
        $response->setCity($address->getCity());
        $response->setPostalCode($address->getPostcode());
        $response->setState($this->getRegionAbbreviation($address));
        $response->setCountry($address->getCountry());
        $response->setComplement($address->getStreet3());
        $response->setPhone(self::formatPhone($address->getTelephone()));

        return $response;
    }

    /**
     * @param $phone
     * @return \RakutenPay\Domains\Phone
     */
    public static function formatPhone($phone)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing formatPhone in ModelOrderAddress.');
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $ddd = '';
        if (strlen($phone) > 9) {
            if (substr($phone, 0, 1) == 0) {
                $phone = substr($phone, 1);
            }
            $ddd = substr($phone, 0, 2);
            $phone = substr($phone, 2);
        }
        $response = new RakutenPay\Domains\Phone();
        $response->setAreaCode($ddd)->setNumber($phone);
        return $response;
    }

    /**
     * @param $fullAddress
     *
     * @return array
     */
    private function parseStreet($fullAddress)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing parseStreet in ModelOrderAddress.');
        $fullAddress = explode(', ', $fullAddress);
        $street = $fullAddress[0];
        $number = isset($fullAddress[1]) ? $fullAddress[1] : null;

        return array(
            'street' => $street,
            'number' => $number,
        );
    }

    /**
     * Get a brazilian region name and return the abbreviation if it exists
     *
     * @param address $address
     *
     * @return string
     */
    private function getRegionAbbreviation($address)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getRegionAbbreviation in ModelOrderAddress.');
        if (!is_null($address->getRegionCode()) && strlen($address->getRegionCode()) == 2) {
            return strtoupper($address->getRegionCode());
        }

        $addressEnum = new \RakutenPay\Enum\Address();

        return (is_string($addressEnum->getType($address->getRegion()))) ?
            strtoupper($addressEnum->getType($address->getRegion())) :
            strtoupper($address->getRegion());
    }

    /**
     * @return \RakutenPay\Domains\Address
     */
    public function getShippingAddress()
    {
        return $this->setAddress($this->shippingAddress);
    }
}
