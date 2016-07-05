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
            'providerId'    => '',
            'secretKey'     => '',
            'testMode'      => false,
        ];
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
     * Get the secret key.
     *
     * @return string secret key
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set the secret key.
     *
     * @param string $value secret key
     *
     * @return self
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }
}
