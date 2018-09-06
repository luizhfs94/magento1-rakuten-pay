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
 * @property Mage_Sales_Model_Order order
 */
class Rakuten_Connector_Model_RakutenPay_CreditCard extends Mage_Payment_Model_Method_Abstract
{
    protected $_canAuthorize = true;
    protected $_canCapture = true;
    protected $_canCapturePartial = false;
    protected $_canRefund = false;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = true;
    protected $_canUseInternal = true;
    protected $_canVoid = true;
    protected $_code = 'rakutenpay_credit_card';
    protected $_isGateway = true;
    /**
     * @var string, path to the template form block
     */
    protected $_formBlockType = 'rakuten_connector_rakutenpay/form_creditCard';
    protected $_infoBlockType = 'rakuten_connector_rakutenpay/info_creditCard';
/**
     * Assign block data
     * @param type $data
     * @return $this
     */
    public function assignData($data)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing assignData in ModelCreditCard.');
        $info = $this->getInfoInstance();

        if ($data->getCreditCardCpf()) {
            $info->setCreditCardCpf($data->getCreditCardCpf());
        }

        if ($data->getCreditCardHash()) {
            $info->setCreditCardHash($data->getCreditCardHash());
        }

        if ($data->getFingerprint()) {
            $info->setFingerprint($data->getFingerprint());
        }

        if ($data->getCreditCardBrand()) {
            $info->setBrand($data->getCreditCardBrand());
        }

        if ($data->getCreditCardCode()) {
            $info->setCvv($data->getCreditCardCode());
        }

        if ($data->getCreditCardHolder()) {
            $info->setCreditCardHolder($data->getCreditCardHolder());
        }

        if ($data->getCreditCardHolderBirthdate()) {
            $info->setCreditCardHolderBirthdate($data->getCreditCardHolderBirthdate());
        }

        if ($data->getCreditCardToken()) {
            $info->setCreditCardToken($data->getCreditCardToken());
        }

        if ($data->getCreditCardInstallment()) {
            $info->setCreditCardInstallment($data->getCreditCardInstallment());
        }

       if ($data->getCreditCardInstallmentValue()) {
            $info->setCreditCardInstallmentValue($data->getCreditCardInstallmentValue());
        }

        if ($data->getCreditCardInterestAmount()) {
            $info->setCreditCardInterestAmount($data->getCreditCardInterestAmount());
        }

        if ($data->getCreditCardInterestPercent()) {
            $info->setCreditCardInterestPercent($data->getCreditCardInterestPercent());
        }

        if ($data->getCreditCardInstallmentTotalValue()) {
            $info->setCreditCardInstallmentTotalValue($data->getCreditCardInstallmentTotalValue());
        }

        Mage::getSingleton('customer/session')
            ->setData('creditCardHash', $info->getCreditCardHash())
            ->setData('creditCardCode', $info->getCvv())
            ->setData('creditCardBrand', $info->getBrand())
            ->setData('fingerprint', $info->getFingerprint())
            ->setData('creditCardDocument', $info->getCreditCardCpf())
            ->setData('creditCardHolder', $info->getCreditCardHolder())
            ->setData('creditCardBirthdate', $info->getCreditCardHolderBirthdate())
            ->setData('creditCardToken', $info->getCreditCardToken())
            ->setData('creditCardInstallment', $info->getCreditCardInstallment())
            ->setData('creditCardInstallmentValue', $info->getCreditCardInstallmentValue())
            ->setData('creditCardInterestAmount', $info->getCreditCardInterestAmount())
            ->setData('creditCardInterestPercent', $info->getCreditCardInterestPercent())
            ->setData('creditCardInstallmentTotalValue', $info->getCreditCardInstallmentTotalValue());

        return $this;
    }

    /**
     * Validate the payment before request
     * @return $this
     */
    public function validate()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing validate in ModelCreditCard.');
        parent::validate();
        $info = $this->getInfoInstance();

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getOrderPlaceRedirectUrl in ModelCreditCard.');
        return Mage::getUrl('rakutenpay/payment/request');
    }
}
