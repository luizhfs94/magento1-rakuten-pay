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

class Rakuten_RakutenLogistics_Helper_Address extends Mage_Core_Helper_Abstract
{
    private $regionMapping = [
        'Acre' => 'AC',
        'Alagoas' => 'AL',
        'Amazonas' => 'AM',
        'Amapá' => 'AP',
        'Bahia' => 'BA',
        'Ceará' => 'CE',
        'Espírito Santos' => 'ES',
        'Goiás' => 'GO',
        'Maranhão' => 'MA',
        'Mato Grosso' => 'MT',
        'Mato Grosso do Sul' => 'MS',
        'Minas Gerais' => 'MG',
        'Pará' => 'PA',
        'Paraíba' => 'PB',
        'Paraná' => 'PR',
        'Pernambuco' => 'PE',
        'Piauí' => 'PI',
        'Rio de Janeiro' => 'RJ',
        'Rio Grande do Norte' => 'RN',
        'Rondônia' => 'RO',
        'Rio Grande do Sul' => 'RS',
        'Roraima' => 'RR',
        'Santa Catarina' => 'SC',
        'Sergipe' => 'SE',
        'São Paulo' => 'SP',
        'Tocantins' => 'TO',
        'Distrito Federal' => 'DF'

    ];

    public function getRegionAbbreviation($region)
    {
        if (!is_null($region) && strlen($region) == 2) {
            return strtoupper($region);
        }

        return isset($this->regionMapping[$region]) ?
            $this->regionMapping[$region] :
            strtoupper($region);
    }
}
