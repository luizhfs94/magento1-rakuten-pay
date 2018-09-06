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
 * Class Rakuten_Connector_Model_RakutenPay_Library
 */
class Rakuten_Connector_Model_RakutenPay_Library
{
    /**
     * Rakuten_Connector_Model_RakutenPay_Library constructor.
     * @throws Exception
     */
    public function __construct()
    {
        defined("SHIPPING_TYPE") or define("SHIPPING_TYPE", 3);
        defined("SHIPPING_COST") or define("SHIPPING_COST", 0.00);
        defined("CURRENCY") or define("CURRENCY", "BRL");
        \RakutenPay\Library::initialize();
        \RakutenPay\Library::cmsVersion()->setName('Magento')->setRelease(Mage::getVersion());
        \RakutenPay\Library::moduleVersion()->setName('Connector')->setRelease(Mage::getConfig()->getModuleConfig("Rakuten_Connector")->version);
        \RakutenPay\Configuration\Configure::setCharset('UTF-8');
        $this->setCharset();
        $this->setEnvironment();
        $this->setLog();
    }

    /**
     *
     */
    private function setCharset()
    {
        \RakutenPay\Configuration\Configure::setCharset('UTF-8');
    }

    /**
     *
     */
    private function setEnvironment()
    {
        \RakutenPay\Configuration\Configure::setEnvironment(Mage::getStoreConfig('payment/connector/environment'));
    }

    /**
     *
     */
    private function setLog()
    {
        if (Mage::getStoreConfig('payment/connector/log')) {
            \RakutenPay\Configuration\Configure::setLog(true,
                Mage::getBaseDir().Mage::getStoreConfig('payment/connector/log_file'));
        } else {
            \RakutenPay\Configuration\Configure::setLog(false, null);
        }
    }

    /**
     * @return \RakutenPay\Domains\AccountCredentials
     */
    public function getAccountCredentials()
    {
        \RakutenPay\Configuration\Configure::setAccountCredentials(
            Mage::getStoreConfig('payment/connector/cnpj'),
            Mage::getStoreConfig('payment/connector/api_key'),
            Mage::getStoreConfig('payment/connector/signature_key')
        );

        return \RakutenPay\Configuration\Configure::getAccountCredentials();
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
        return Mage::getStoreConfig('payment/connector/environment');
    }

    /**
     * @return mixed
     */
    public function getLog()
    {
        return Mage::getStoreConfig('payment/connector/log');
    }

    /**
     * @return mixed
     */
    public function getPaymentCheckoutType()
    {
        return Mage::getStoreConfig('payment/rakutenpay_default_lightbox/checkout');
    }
}
