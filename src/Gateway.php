<?php

/*
 * Qiwi driver for Omnipay PHP payment library
 */

namespace Omnipay\Qiwi;

use Omnipay\Common\AbstractGateway;

/**
 * Gateway for Visa QIWI Wallet.
 * @see https://static.qiwi.com/ru/doc/ishop/protocols/OnlineStoresProtocols_REST.pdf
 */
class Gateway extends AbstractGateway
{

    const PAY_SOURCE_QW = 'qw';
    const PAY_SOURCE_MOBILE = 'mobile';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Qiwi';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'apiId'       => '',
            'apiPassword' => '',
            'providerId'    => '',
        ];
    }

    /**
     * Get the API ID.
     *
     * @return string provider ID
     */
    public function getApiId()
    {
        return $this->getParameter('apiId');
    }

    /**
     * Set the API ID.
     *
     * @param string $value
     *
     * @return self
     */
    public function setApiId($value)
    {
        return $this->setParameter('apiId', $value);
    }

    /**
     * Get the api password.
     *
     * @return string secret key
     */
    public function getApiPassword()
    {
        return $this->getParameter('apiPassword');
    }

    /**
     * Set the api password.
     *
     * @param string $value
     *
     * @return self
     */
    public function setApiPassword($value)
    {
        return $this->setParameter('apiPassword', $value);
    }

    /**
     * Get the provider ID.
     *
     * @return string provider ID
     */
    public function getProviderId()
    {
        return $this->getParameter('providerId');
    }

    /**
     * Set the provider ID.
     *
     * @param string $value provider ID
     *
     * @return self
     */
    public function setProviderId($value)
    {
        return $this->setParameter('providerId', $value);
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

    public function purchase(array $parameters = array())
    {
        return $this->authorize($parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Qiwi\Message\InvoiceRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function getPurchaseStatus(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Qiwi\Message\InvoiceStatusRequest', $parameters);
    }
}
