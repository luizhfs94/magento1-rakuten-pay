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
 * Class Rakuten_RakutenPay_Model_Library
 */
class Rakuten_RakutenPay_Model_Library
{
    /**
     * Rakuten_RakutenPay_Model_Library constructor.
     */
    public function __construct()
    {
        defined("SHIPPING_TYPE") or define("SHIPPING_TYPE", 3);
        defined("SHIPPING_COST") or define("SHIPPING_COST", 0.00);
        defined("CURRENCY") or define("CURRENCY", "BRL");
        \RakutenConnector\Library::initialize();
        \RakutenConnector\Library::cmsVersion()->setName('Magento')->setRelease(Mage::getVersion());
        \RakutenConnector\Library::moduleVersion()->setName('RakutenPay')->setRelease(Mage::getConfig()->getModuleConfig("Rakuten_RakutenPay")->version);
        \RakutenConnector\Configuration\Configure::setCharset('UTF-8');
        $this->setCharset();
        $this->setEnvironment();
        $this->setLog();
    }

    /**
     *
     */
    private function setCharset()
    {
        \RakutenConnector\Configuration\Configure::setCharset('UTF-8');
    }

    /**
     *
     */
    private function setEnvironment()
    {
        \RakutenConnector\Configuration\Configure::setEnvironment(Mage::getStoreConfig('payment/rakutenpay/environment'));
    }

    /**
     *
     */
    private function setLog()
    {
        if (Mage::getStoreConfig('payment/rakutenpay/log')) {
            \RakutenConnector\Configuration\Configure::setLog(true,
                Mage::getBaseDir().Mage::getStoreConfig('payment/rakutenpay/log_file'));
        } else {
            \RakutenConnector\Configuration\Configure::setLog(false, null);
        }
    }

    /**
     * @return \RakutenConnector\Domains\AccountCredentials
     */
    public function getAccountCredentials()
    {
        \RakutenConnector\Configuration\Configure::setAccountCredentials(
            Mage::getStoreConfig('payment/rakutenpay/cnpj'),
            Mage::getStoreConfig('payment/rakutenpay/api_key'),
            Mage::getStoreConfig('payment/rakutenpay/signature_key')
        );

        return \RakutenConnector\Configuration\Configure::getAccountCredentials();
    }

    /**
     * @return mixed
     */
    public function getCharset()
    {
        return 'UTF-8';
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return Mage::getStoreConfig('payment/rakutenpay/environment');
    }

    /**
     * @return mixed
     */
    public function getLog()
    {
        return Mage::getStoreConfig('payment/rakutenpay/log');
    }

    /**
     * @return mixed
     */
    public function getPaymentCheckoutType()
    {
        return Mage::getStoreConfig('payment/rakutenpay_default_lightbox/checkout');
    }
}
