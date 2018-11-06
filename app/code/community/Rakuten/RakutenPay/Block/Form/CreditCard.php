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
/**
 * Form block for credit card payment
 */
class Rakuten_RakutenPay_Block_Form_CreditCard extends Mage_Payment_Block_Form
{
   protected function _construct()
    {
        parent::_construct();
        $this->initializeRakutenPay();
        $totals = Mage::getSingleton('checkout/session')->getQuote()->getTotals()['grand_total'];
        $this->setGrandTotal($totals->getData()['value']);
        $paymentMethodModel = Mage::getSingleton('Rakuten_RakutenPay_Model_PaymentMethod');
        $this->setCreditCardSession($paymentMethodModel->getSession());
        $this->setTemplate('rakuten/rakutenpay/form/creditcard.phtml');
    }

    protected function _prepareLayout()
    {
        $directPaymentCss = 'rakuten/rakutenpay/css/direct-payment.css';
        $paymentMethodModel = Mage::getSingleton('Rakuten_RakutenPay_Model_PaymentMethod');
        if ($paymentMethodModel->hasOneStepCheckout()) {
            $directPaymentCss = 'rakuten/rakutenpay/css/direct-payment-onestepcheckout.css';
        }

        if ($this->getLayout()->getBlock('head')) {
            $this->getLayout()->getBlock('head')->addItem('skin_js', 'rakuten/rakutenpay/js/direct-payment.js');
            $this->getLayout()->getBlock('head')->addItem('skin_js', 'rakuten/rakutenpay/js/credit-card.js');
            $this->getLayout()->getBlock('head')->addItem('skin_css', $directPaymentCss);
        }
    }

    /**
     * Set variables to be used in boleto form (boleto.phtml)
     */
    private function initializeRakutenPay()
    {
        $skinUrl = 'rakuten/rakutenpay/js/rakutenpay-before-save.js';
        $paymentMethodModel = Mage::getSingleton('Rakuten_RakutenPay_Model_PaymentMethod');
        if ($paymentMethodModel->hasOneStepCheckout()) {
            $skinUrl = 'rakuten/rakutenpay/js/rakutenpay-onestepcheckout-before-save.js';
        }

        // Set Values for get in View
        $this->setRakutenPayBeforeSaveJsSkinUrl($this->getSkinUrl($skinUrl));
        $this->setHasOneStepCheckout($paymentMethodModel->hasOneStepCheckout());
    }
}
