<?php

namespace Omnipay\Qiwi\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class InvoiceStatusResponse
 *
 * @package Omnipay\Qiwi\Message
 */
class InvoiceStatusResponse extends AbstractResponse
{
    const SUCCESS_RESPONSE_CODE = 0;

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->checkResponse();
    }

    /**
     * {@inheritDoc}
     */
    public function getMessage()
    {
        return sprintf('<?xml version="1.0"?><result><result_code>%s</result_code></result>',
            self::SUCCESS_RESPONSE_CODE);
    }

    /**
     * @return null|string
     */
    public function getStatus()
    {
        return $this->checkResponse() ?  $this->data['response']['bill']['status'] : null;
    }

    /**
     * @return bool
     */
    private function checkResponse()
    {
        if (!array_key_exists('response',  $this->data)) {
            return false;
        }

        $data = $this->data['response'];
        return array_key_exists('result_code',  $data)
        && array_key_exists('bill',  $data) && is_array($data['bill'])  && array_key_exists('error', $data['bill'])
        && $data['result_code'] === self::SUCCESS_RESPONSE_CODE
        && $data['bill']['error'] === 0 ;
    }
}