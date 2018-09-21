<?php
/**
 ************************************************************************
 * Copyright [2017] [RakutenConnector]
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

namespace RakutenConnector\Parsers\Transaction\Boleto;

/**
 * Class Response
 * @package RakutenConnector\Parsers\Transaction\Boleto
 */
class Response extends \RakutenConnector\Parsers\Transaction\Response
{
    private $result;

    private $id;

    private $charge;

    private $billet;

    function getResult() {
        return $this->result;
    }

    function getId() {
        return $this->id;
    }

    function getCharge() {
        return $this->charge;
    }

    function getBillet() {
        return $this->billet;
    }

    function setResult($result) {
        $this->result = $result;
        return $this;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setCharge($charge) {
        $this->charge = $charge;
        return $this;
    }

    function setBillet($billet) {
        $this->billet = $billet;
        return $this;
    }


}
