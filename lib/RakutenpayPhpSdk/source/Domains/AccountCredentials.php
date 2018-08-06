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

namespace RakutenPay\Domains;

use RakutenPay\Domains\Account\Credentials;

/**
 * Class AccountCredentials
 * @package RakutenPay\Domains
 */
class AccountCredentials implements Credentials
{

    /**
     * @var
     */
    private $cnpj;
    /**
     * @var
     */
    private $api_key;
    /**
     * @var
     */
    private $signature_key;

    /**
     * AccountCredentials constructor.
     * @param null|string $email
     * @param null|string $token
     */
    public function __construct($cnpj = null, $api_key = null, $signature_key = null)
    {
        if (!is_null($cnpj)) {
            $this->setCnpj($cnpj);
        }
        if (!is_null($api_key)) {
            $this->setApiKey($api_key);
        }
        if (!is_null($signature_key)) {
            $this->setSignatureKey($signature_key);
        }
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function getApiKey()
    {
        return $this->api_key;
    }

    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
        return $this;
    }

    public function getSignatureKey()
    {
        return $this->signature_key;
    }

    public function setSignatureKey($signature_key)
    {
        $this->signature_key = $signature_key;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributesMap()
    {
        return [
            'cnpj' => $this->getCnpj(),
            'api_key' => $this->getApiKey(),
            'signature_key' => $this->getSignatureKey()
        ];
    }

    /**
     * @return string
     */
    public function toString()
    {
        return sprintf(
            "AccountCredentials[ CNPJ : %s , API key: %s, Signature key: %s ]",
            $this->getCnpj(),
            $this->getApiKey(),
            $this->getSignatureKey()
        );
    }
}
