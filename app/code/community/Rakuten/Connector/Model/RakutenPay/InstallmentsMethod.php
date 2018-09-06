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

use Mage_Payment_Model_Method_Abstract as MethodAbstract;

/**
 * RakutenPay installments model
 */
class Rakuten_Connector_Model_RakutenPay_InstallmentsMethod extends MethodAbstract
{
    protected $_code = 'connector_rakutenpay';
    /**
     * @var Rakuten_RakutenPay_Model_Library
     */
    private $library;

    /**
     * Construct
     */
    public function __construct()
    {
        \RakutenPay\Resources\Log\Logger::info('Constructing ModelInstallmentsMethod.');
        $this->helper = Mage::helper('connector_rakutenpay');
        $this->library = new Rakuten_Connector_Model_RakutenPay_Library();
    }

    /**
     * Get the bigger installments list returned by the RakutenPay service
     *
     * @param mixed  $amount
     * @param string $brand
     *
     * @return array | false
     */
    public function create($amount)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing create in ModelInstallmentsMethod.');
        $this->helper = Mage::helper('connector_rakutenpay');
        try {
            $session = \Mage::getSingleton('checkout/session');
            $minimum_value = \Mage::getStoreConfig("payment/rakutenpay_credit_card/minimum_installment");
            $installments = self::createInstallments($amount, $minimum_value);
            $format = $this->output($installments, true);

            return $format['installments'];
        } catch (Exception $exception) {
            Mage::log($exception->getMessage());

            return false;
        }
    }

    /**
     * Returns the maximum number of installments
     */
    private function getMaxNoInstallments($amount, $minimum_value)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getMaxNoInstallments in ModelInstallmentsMethod.');
        if (is_null($minimum_value) || is_nan($minimum_value) || $minimum_value < 0) {
            $minimum_value = 10.0;
        }
        $installments = $amount / $minimum_value;
        return floor($installments);
    }

    /**
     * Returns an array of installments
     */
    private function createInstallments($amount, $minimum_value)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing createInstallments in ModelInstallmentsMethod.');
        $arr = [];
        if (Mage::getStoreConfig('payment/rakutenpay_credit_card/customer_interest') == 1)
        {
            $checkout = \RakutenPay\Services\Transactions\Checkout::get(
                ['amount' => $amount]
            );
            $minimum_installment = (int)Mage::getStoreConfig('payment/rakutenpay_credit_card/customer_interest_minimum_installments');
            foreach($checkout->getCreditCardPayment()->getInstallments() as $customerInterestInstallment) {
                $installment = new RakutenPay\Domains\Responses\Installment;
                if ((int)$customerInterestInstallment->getQuantity() >= $minimum_installment){
                    $installment
                    ->setAmount($customerInterestInstallment->getInstallmentAmount())
                    ->setQuantity($customerInterestInstallment->getQuantity())
                    ->setTotalAmount($customerInterestInstallment->getTotal())
                    ->setInterestAmount($customerInterestInstallment->getInterestAmount())
                    ->setInterestPercent($customerInterestInstallment->getInterestPercent())
                    ->setInterestFree(false);
                }
                else {
                    $installment
                    ->setAmount($customerInterestInstallment->getInstallmentAmount() - $customerInterestInstallment->getInterestAmount())
                    ->setQuantity($customerInterestInstallment->getQuantity())
                    ->setTotalAmount($customerInterestInstallment->getQuantity() * ($customerInterestInstallment->getInstallmentAmount() - $customerInterestInstallment->getInterestAmount()))
                    ->setInterestAmount(0.0)
                    ->setInterestPercent(0.0)
                    ->setInterestFree(true);

                }
                $arr[] = $installment;
            }
        } else {
            $maxNoInstallments = self::getMaxNoInstallments($amount, $minimum_value);
            for ($mo = 1; $mo <= $maxNoInstallments; $mo++) {
                $value = $amount / $mo;
                $value = ceil($value * 100) / 100;// rounds up to the nearest cent
                $total = $value * $mo;
                $total = ceil($total * 100) / 100;
                $installment = new RakutenPay\Domains\Responses\Installment;
                $installment
                ->setAmount($value)
                ->setQuantity($mo)
                ->setTotalAmount($total)
                ->setInterestAmount(0.0)
                ->setInterestPercent(0.0)
                ->setInterestFree(true);
                $arr[] = $installment;
            }
        }
        return $arr;
    }

    /**
     * Return a formated output of installments
     *
     * @param array $installments
     * @param bool  $maxInstallment
     *
     * @return array
     */
    private function output($installments, $maxInstallment)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing output in ModelInstallmentsMethod.');
        return ($maxInstallment) ?
            $this->formatOutput($this->getMaxInstallment($installments)) :
            $this->formatOutput($installments);
    }

    /**
     * Format the installment to the be show in the view
     *
     * @param  array $installments
     *
     * @return array
     */
    private function formatOutput($installments)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing formatOutput in ModelInstallmentsMethod.');
        $response = $this->getOptions();
        foreach ($installments as $installment) {
            $response['installments'][] = $this->formatInstallments($installment);
        }

        return $response;
    }

    /**
     * Format a installment for output
     *
     * @param $installment
     *
     * @return array
     */
    private function formatInstallments($installment)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing formatInstallments in ModelInstallmentsMethod.');
        return array(
            'quantity'        => $installment->getQuantity(),
            'amount'          => $installment->getAmount(),
            'totalAmount'     => RakutenPay\Helpers\Currency::toDecimal($installment->getTotalAmount()),
            'text'            => str_replace('.', ',', $this->getInstallmentText($installment)),
            'interestAmount'  => $installment->getInterestAmount(),
            'interestPercent' => $installment->getInterestPercent()
        );
    }

    /**
     * Mount the text message of the installment
     *
     * @param  object $installment
     *
     * @return string
     */
    private function getInstallmentText($installment)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getInstallmentText in ModelInstallmentsMethod.');
        return sprintf(
            "%s x de R$ %.2f %s juros",
            $installment->getQuantity(),
            $installment->getAmount(),
            $this->getInterestFreeText($installment->getInterestFree()));
    }

    /**
     * Get the string relative to if it is an interest free or not
     *
     * @param string $insterestFree
     *
     * @return string
     */
    private function getInterestFreeText($insterestFree)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getInterestFreeText in ModelInstallmentsMethod.');
        return ($insterestFree == 'true') ? 'sem' : 'com';
    }

    /**
     * Get the bigger installments list in the installments
     *
     * @param array $installments
     *
     * @return array
     */
    private function getMaxInstallment($installments)
    {
        \RakutenPay\Resources\Log\Logger::info('Processing getMaxInstallment in ModelInstallmentsMethod.');
        $final = $current = array('brand' => '', 'start' => 0, 'final' => 0, 'quantity' => 0);
        foreach ($installments as $key => $installment) {
            if ($current['brand'] !== $installment->getCardBrand()) {
                $current['brand'] = $installment->getCardBrand();
                $current['start'] = $key;
            }
            $current['quantity'] = $installment->getQuantity();
            $current['end'] = $key;
            if ($current['quantity'] > $final['quantity']) {
                $final = $current;
            }
        }

        return array_slice(
            $installments,
            $final['start'],
            $final['end'] - $final['start'] + 1
        );
    }

    /**
     * Check if installments show is enabled
     */
    public function enabled()
    {
        \RakutenPay\Resources\Log\Logger::info('Processing enabled in ModelInstallmentsMethod.');
        return (Mage::getStoreConfig('payment/rakutenpay/installments') == 1) ?
            true :
            false;
    }
}
