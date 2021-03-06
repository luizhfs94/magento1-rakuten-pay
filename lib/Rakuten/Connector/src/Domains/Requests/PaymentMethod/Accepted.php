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

namespace Rakuten\Connector\Domains\Requests\PaymentMethod;

/**
 * Trait Accepted
 * @package Rakuten\Connector\Domains\Requests\PaymentMethod
 */
trait Accepted
{
    private $accept;
    private $exclude;

    /**
     * @return \Rakuten\Connector\Resources\Factory\Request\Accepted
     */
    public function accept()
    {
        if (is_null($this->accept)) {
            $this->accept = new \Rakuten\Connector\Resources\Factory\Request\Accepted();
        }
        return $this->accept;
    }

    /**
     * @return \Rakuten\Connector\Resources\Factory\Request\Accepted
     */
    public function exclude()
    {
        if (is_null($this->exclude)) {
            $this->exclude = new \Rakuten\Connector\Resources\Factory\Request\Accepted();
        }
        return $this->exclude;
    }

    public function getAttributeMap()
    {
        return [
          'accept' => $this->accept,
          'exclude' => $this->exclude,
        ];
    }
}
