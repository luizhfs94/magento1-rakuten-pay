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

namespace RakutenPay\Resources;

use RakutenPay\Configuration\Configure;

/**
 * Class Builder
 * @package RakutenPay\Resources
 */
class Builder
{

    /**
     * @return string
     */
    protected static function getResourcesFile()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getResourcesFile in Builder.');
        $resources = __DIR__ . '/../Configuration/Properties/Resources.xml';

        if (defined('RP_RESOURCES')) {
            $resources = RP_RESOURCES;
        }

        return $resources;
    }

    /**
     * @param null $protocol
     * @return string
     */
    protected static function getUrl($protocol = null)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getUrl in Builder.');
        $xml = simplexml_load_file(self::getResourcesFile());

        if (is_null($protocol)) {
            $protocol = $xml->path->protocol;
        }
        $environment = Configure::getEnvironment()->getEnvironment();
        return sprintf(
            "%s://%s",
            $protocol,
            current($xml->path->environment->{$environment})
        );
    }

    /**
     * @param $url
     * @param $service
     * @return string
     */
    protected static function getRequest($url, $service)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getRequest in Builder.');
        return self::getService($url, $service, 'request');
    }

    /**
     * @param $url
     * @param $service
     * @return string
     */
    protected static function getResponse($url, $service)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getResponse in Builder.');
        return self::getService($url, $service, 'response');
    }

    /**
     * @param $url
     * @param $service
     * @param $http
     * @return string
     */
    protected static function getService($url, $service, $http)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getService in Builder.');
        $xml = simplexml_load_file(self::getResourcesFile());
        $values = self::getProperties($xml, $service, $http);
        if (isset($values))
            return sprintf(
                "%s/%s",
                $url,
                current($values)
            );
        else {
            \RakutenPay\Resources\Log\Logger::error ('Cannot get service: ' . $service . ', http: ' . $http);
            throw new \Exception('Cannot get service: ' . $service . ', http: ' . $http);
        }
    }

    /**
     * @param $xml
     * @param $service
     * @param $http
     * @return mixed
     */
    private static function getProperties($xml, $service, $http)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getProperties in Builder.');
        $services = explode("/", $service);
        if (isset($services[1])) {
            return $xml->services->{$services[0]}->{$services[1]}->{$http};
        } else {
            return $xml->services->{$service}->{$http};
        }
    }
}
