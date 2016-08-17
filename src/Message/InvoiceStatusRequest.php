<?php

namespace Omnipay\Qiwi\Message;

/**
 * Class InvoiceStatusRequest
 *
 * @package Omnipay\Qiwi\Message
 */
class InvoiceStatusRequest extends AuthorizeRequest
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('transactionId', 'providerId', 'amount', 'currency');
        return array();
    }

    /**
     * {@inheritdoc}
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * {@inheritdoc}
     */
    protected function createResponse(array $data)
    {

        if (!array_key_exists('response', $data)) {
            throw new \InvalidArgumentException('Invalid response');
        }

        if (array_key_exists('bill', $data['response'])) {
            if ((double)$this->getAmount() !== (double)$data['response']['bill']['amount']) {
                throw new \InvalidArgumentException('Payment amount does not match');
            }

            if ($this->getCurrency() !== $data['response']['bill']['ccy']) {
                throw new \InvalidArgumentException('Currency does not match');
            }
        } // else Invalid code response


        return $this->response = new InvoiceStatusResponse($this, $data);
    }
}