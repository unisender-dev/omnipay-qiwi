<?php

namespace Omnipay\Qiwi\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class CompletePurchaseRequest extends AbstractRequest
{

    /**
     * @return string
     */
    public function getApiId()
    {
        return $this->getParameter('apiId');
    }

    /**
     * @param string $value
     *
     * @return self
     */
    public function setApiId($value)
    {
        return $this->setParameter('apiId', $value);
    }

    /**
     * @return string
     */
    public function getNotifyPassword()
    {
        return $this->getParameter('notifyPassword');
    }


    /**
     * @return string
     */
    public function setNotifyPassword($value)
    {
        return $this->setParameter('notifyPassword', $value);
    }

    private function validateCallback()
    {
        $base64EncodedPair = str_replace('Basic ', '',  $this->httpRequest->get('Authorization'));
        if ($base64EncodedPair !== base64_encode($this->getApiId() . ':' . $this->getNotifyPassword()) ) {
            throw new \RuntimeException('Authorization failed');
        }

        if ($this->getAmount() !== $this->httpRequest->get('amount')) {
            throw new \InvalidArgumentException('Payment amount does not match');
        }

        if ($this->getCurrency() !== $this->httpRequest->get('ccy')) {
            throw new \InvalidArgumentException('Currency does not match');
        }


        $transactionId = $this->httpRequest->get('bill_id');
        if ($this->getTestMode() !== (bool) preg_match('/^_TEST_(.*)$/', $transactionId)) {
            throw new \InvalidArgumentException('Currency does not match');
        }

        if ((preg_match('/^_TEST_(.*)$/', $this->httpRequest->get('bill_id'), $match))) {
            $transactionId = $match[1];
        }

        if ($transactionId !== (string) $this->getTransactionId()) {
            throw new \InvalidArgumentException('Transaction does not match');
        }

    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'notifyPassword', 'transactionId');
        $this->validateCallback();

        $data = $this->httpRequest->request->all();
        if ((preg_match('/^_TEST_(.*)$/', $data['bill_id'], $match))) {
            $data['bill_id'] = $match[1];
        }

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return new CompletePurchaseResponse($this, $data);
    }
}