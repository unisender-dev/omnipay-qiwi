<?php

namespace Omnipay\Qiwi\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class Response extends AbstractResponse
    implements RedirectResponseInterface
{
    const SUCCESS_RESPONSE_CODE = 0;

    protected $liveEndpointRedirect = 'https://qiwi.com/order/external/main.action';

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return !$this->isRedirect() && $this->checkResponse();
    }

    public function isRedirect()
    {
        $redirectData = $this->getRedirectData();
        return $redirectData['successUrl']  !== null && $redirectData['failUrl'] !== null;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectUrl()
    {
        return $this->liveEndpointRedirect . '?' . http_build_query($this->getRedirectData());
    }

    public function getRedirectData()
    {
        return [
            'successUrl'  => array_key_exists('returnUrl', $this->data) ? $this->data['returnUrl'] : null,
            'failUrl'     => array_key_exists('cancelUrl', $this->data) ? $this->data['cancelUrl'] : null,
            'shop'        => array_key_exists('providerId', $this->data) ? $this->data['providerId'] : null,
            'transaction' => array_key_exists('transactionId', $this->data) ? (string) $this->data['transactionId'] : null,
        ];
    }

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