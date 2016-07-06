<?php

namespace Omnipay\Qiwi\Message;

class InvoiceStatusRequest extends AuthorizeRequest
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('transactionId', 'providerId');
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
        return $this->response = new Response($this, $data);
    }
}