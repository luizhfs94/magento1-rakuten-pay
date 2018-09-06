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
 * Class Rakuten_Connector_Model_Observer
 */
class Rakuten_Connector_Model_Observer
{
    /**
     * @var string
     */
    protected $libPath;

    /**
     * Rakuten_Connector_Model_Observer constructor.
     */
    public function __construct()
    {
        $this->libPath = Mage::getBaseDir('lib'). '/RakutenpayPhpSdk/vendor/autoload.php';
    }

    /**
     * @return $this
     */
    public function addAutoloader()
    {
        include_once($this->libPath);
        return $this;
    }
}
