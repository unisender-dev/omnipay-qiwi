<?php

namespace Omnipay\Qiwi\Message;


use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Qiwi\Gateway;

class InvoiceRequest extends AuthorizeRequest
{
    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    /**
     * @param string $value
     *
     * @return self
     */
    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }


    /**
     * @param string $value
     *
     * @return self
     */
    public function setLifetime($value)
    {
        return $this->setParameter('lifetime', $value);
    }

    /**
     * @return string
     */
    public function getLifetime()
    {
        return $this->getParameter('lifetime');
    }

    /**
     * @param string $value
     *
     * @return self
     */
    public function setPaySource($value)
    {
        return $this->setParameter('paySource', $value);
    }

    /**
     * @return string
     */
    public function getPaySource()
    {
        return $this->getParameter('paySource');
    }

    /**
     * @param string $value
     *
     * @return self
     */
    public function setPayName($value)
    {
        return $this->setParameter('payName', $value);
    }

    /**
     * @return string
     */
    public function getPayName()
    {
        return $this->getParameter('payName');
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'description', 'phone', 'transactionId', 'providerId');

        $data = array();
        $data['amount'] = $this->getAmount();
        $data['ccy'] = $this->getCurrency();
        $data['comment'] = $this->getDescription();
        $data['user'] = 'tel:+' . $this->getPhone();
        $data['lifetime'] =  $this->getLifetime() ?: date('c', time() + 86400);
        $data['pay_source'] = $this->getPaySource() ?: Gateway::PAY_SOURCE_QW;

        if ((string)$this->getPayName() !== '') {
            $data['prv_name'] = $this->getPayName();
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    protected function getHttpMethod()
    {
        return 'PUT';
    }

    /**
     * @param array $data
     *
     * @return ResponseInterface
     */
    protected function createResponse(array $data)
    {
        if ($this->getReturnUrl() && $this->getCancelUrl()) {
            $data['returnUrl'] = $this->getReturnUrl();
            $data['cancelUrl'] = $this->getCancelUrl();
            $data['providerId'] = $this->getProviderId();
            $data['transactionId'] = $this->getTransactionId();
        }

        return $this->response = new Response($this, $data);
    }

}