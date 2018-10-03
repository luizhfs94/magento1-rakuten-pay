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

namespace Rakuten\Connector\Domains\Requests;

use Rakuten\Connector\Helpers\InitializeObject;

/**
 * Trait Parameter
 * @package Rakuten\Connector\Domains\Requests
 */
trait Parameter
{
    private $parameter;
    
    public function addParameter()
    {
        $this->parameter = InitializeObject::Initialize(
            $this->parameter,
            new \Rakuten\Connector\Resources\Factory\Request\Parameter()
        );
        
        return $this->parameter;
    }

    public function setParameter($parameter)
    {
        if (is_array($parameter)) {
            $arr = array();
            foreach ($parameter as $key => $parameterItem) {
                if ($parameterItem instanceof \Rakuten\Connector\Domains\Parameter) {
                    $arr[$key] = $parameterItem;
                } else {
                    if (is_array($parameter)) {
                        $arr[$key] = new \Rakuten\Connector\Domains\Parameter($parameterItem);
                    }
                }
            }
            $this->parameter = $arr;
        }
    }

    public function getParameter()
    {
        return current($this->parameter);
    }

    public function parameterLenght()
    {
        return (! is_null($this->parameter)) ? count(current($this->parameter)) : 0;
    }
}
