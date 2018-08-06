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

namespace RakutenPay\Parsers;

use RakutenPay\Helpers\Characters;

/**
 * Class Moede
 * @package RakutenPay\Parsers\Customer
 */
trait Customer
{
    /**
     * @param $request
     * @param $properties
     * @return array
     */
    public static function getData($request, $properties)
    {
        $data = [];
        $customer_data = [];
        if (!is_null($request->getSender())) {
            //document
            if (!is_null($request->getSender()->getDocuments()) and !is_null($request->getSender()->getDocuments())) {
                $customer_data[$properties::DOCUMENT] = Characters::hasSpecialChars($request->getSender()->getDocuments()[0]->getIdentifier());
            }
            //name
            if (!is_null($request->getSender()->getName())) {
                $customer_data[$properties::NAME] = $request->getSender()->getName();
                $customer_data[$properties::BUSINESS_NAME] = $request->getSender()->getName();
            }
            //email
            if (!is_null($request->getSender()->getEmail())) {
                $customer_data[$properties::SENDER_EMAIL] = $request->getSender()->getEmail();
            }
            //birth_date
            if (!is_null($request->getSender()->getBirthdate())) {
                $customer_data[$properties::BIRTH_DATE] = $request->getSender()->getBirthdate();
            }
            //gender
            if (!is_null($request->getSender()->getGender())) {
                switch ($request->getSender()->getGender()) {
                    case 1:
                        $customer_data[$properties::GENDER] = 'm';
                        break;
                    case 2:
                        $customer_data[$properties::GENDER] = 'f';
                        break;
                }
            }
            //remote_ip
            $customer_data[$properties::REMOTE_IP] = \Mage::helper('core/http')->getRemoteAddr();
            //addresses
            $customer_data[$properties::ADDRESSES] = self::getAddresses($request, $properties);
            //phones
            $customer_data[$properties::PHONES] = self::getPhones($request, $properties);
            //kind
            $customer_data[$properties::KIND] = "personal";
        }
        $data[$properties::CUSTOMER] = $customer_data;
        return $data;
    }

    private static function getAddresses($request, $properties)
    {
        $addresses = [];
        if (method_exists($request, 'getBilling') and !is_null($request->getBilling()) and !is_null($request->getBilling()->getAddress())) {
            $addresses[] = self::getAddress($request->getBilling()->getAddress(), $properties, $properties::BILLING);
        }
        if (method_exists($request, 'getShipping') and !is_null($request->getShipping()) and !is_null($request->getShipping()->getAddress())) {
            $addresses[] = self::getAddress($request->getShipping()->getAddress(), $properties, $properties::SHIPPING);
        } elseif (method_exists($request, 'getBilling') and !is_null($request->getBilling()) and !is_null($request->getBilling()->getAddress())) {
            $addresses[] = self::getAddress($request->getBilling()->getAddress(), $properties, $properties::SHIPPING);
        }
        return $addresses;
    }

    private static function getAddress($address, $properties, $kind)
    {
        $address_data = [];
        //kind
        $address_data[$properties::KIND] = $kind;
        //contact
        if (!is_null($address->getName())) {
            $address_data[$properties::CONTACT] = $address->getName();
        }
        //street
        if (!is_null($address->getStreet())) {
            $address_data[$properties::STREET] = $address->getStreet();
        }
        //number
        if (!is_null($address->getNumber())) {
            $address_data[$properties::NUMBER] = $address->getNumber();
        } else {
            $address_data[$properties::NUMBER] = '___';
        }
        //complement
        if (!is_null($address->getComplement())) {
            $address_data[$properties::COMPLEMENT] = $address->getComplement();
        }
        //district
        if (!is_null($address->getDistrict()) and $address->getDistrict() !== '') {
            $address_data[$properties::DISTRICT] = $address->getDistrict();
        } else {
            // In case the configuration does not have districts...
            $address_data[$properties::DISTRICT] = '___';
        }
        //city
        if (!is_null($address->getCity())) {
            $address_data[$properties::CITY] = $address->getCity();
        }
        //state
        if (!empty($address->getState())) {
            $address_data[$properties::STATE] = $address->getState();
        } else {
            $address_data[$properties::STATE] = '___';
        }
        //zipcode
        if (!is_null($address->getPostalCode())) {
            $address_data[$properties::ZIPCODE] = $address->getPostalCode();
        }
        //country
        if (!is_null($address->getCountry())) {
            $address_data[$properties::COUNTRY] = $address->getCountry();
        }
        return $address_data;
    }

    private static function getPhones($request, $properties)
    {
        $phones = [];
        if (!is_null($request->getBilling()->getAddress()->getPhone())) {
            $phones[] = self::getPhone($request->getBilling()->getAddress()->getPhone(), $properties, $properties::BILLING);
        }
        if (!is_null($request->getShipping()->getAddress()->getPhone())) {
            $phones[] = self::getPhone($request->getShipping()->getAddress()->getPhone(), $properties, $properties::SHIPPING);
        } elseif (!is_null($request->getBilling()->getAddress()->getPhone())) {
            $phones[] = self::getPhone($request->getBilling()->getAddress()->getPhone(), $properties, $properties::SHIPPING);
        }
        return $phones;
    }

    private static function getPhone($phone, $properties, $kind)
    {
        $phone_data = [];
        $phone_number = [];
        // kind
        $phone_data[$properties::KIND] = $kind;
        // reference
        $phone_data[$properties::REFERENCE] = "home";

        //country_code
        $phone_number[$properties::COUNTRY_CODE] = "55";
        //area_code
        if (!is_null($phone->getAreaCode())) {
            $phone_number[$properties::AREA_CODE] = $phone->getAreaCode();
        }
        //number
        if (!is_null($phone->getNumber())) {
            $phone_number[$properties::PHONE_NUMBER] = $phone->getNumber();
        }

        $phone_data[$properties::PHONE_NUMBER] = $phone_number;
        return $phone_data;
    }
}
