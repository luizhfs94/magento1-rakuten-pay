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
class Rakuten_RakutenPay_Model_Boleto extends Mage_Payment_Model_Method_Abstract
{

    protected $_canAuthorize = true;
    protected $_canCapture = true;
    protected $_canCapturePartial = false;
    protected $_canRefund = false;
    protected $_canUseCheckout = true;
    protected $_canUseForMultishipping = true;
    protected $_canUseInternal = true;
    protected $_canVoid = true;
    protected $_code = 'rakutenpay_boleto';
    protected $_isGateway = true;
    protected $_formBlockType = 'rakuten_rakutenpay/form_boleto';
    protected $_infoBlockType = 'rakuten_rakutenpay/info_boleto';

    public function assignData($data)
    {
        $info = $this->getInfoInstance();

        if ($data->getBoletoCpf()) {
            $info->setBoletoCpf($data->getBoletoCpf());
        }

        if ($data->getBoletoHash()) {
            $info->setBoletoHash($data->getBoletoHash());
        }

        if ($data->getFingerprint()) {
            $info->setFingerprint($data->getFingerprint());
        }

        Mage::getSingleton('customer/session')
            ->setData('boletoHash', $info->getBoletoHash())
            ->setData('fingerprint', $info->getFingerprint())
            ->setData('boletoDocument', $info->getBoletoCpf());

        return $this;
    }

    public function validate()
    {
        parent::validate();
        $info = $this->getInfoInstance();
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('rakutenpay/payment/request');
    }

}
