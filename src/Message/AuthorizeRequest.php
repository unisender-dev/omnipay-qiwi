<?php

namespace Omnipay\Qiwi\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

abstract class AuthorizeRequest extends AbstractRequest
{

    protected $liveEndpoint = 'https://api.qiwi.com/api/v2/prv/';

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
    public function getApiPassword()
    {
        return $this->getParameter('apiPassword');
    }

    /**
     * Get the provider ID.
     *
     * @return int
     */
    public function getProviderId()
    {
        return $this->getParameter('providerId');
    }

    /**
     * Set the provider ID.
     *
     * @param int $value
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
    public function setApiPassword($value)
    {
        return $this->setParameter('apiPassword', $value);
    }

    public function getEndpoint()
    {
        return $this->liveEndpoint . sprintf('%d/bills/%s', $this->getProviderId(), $this->getTransactionId());
    }

    public function sendData($data)
    {
        $headers = ['Authorization' => 'Basic ' . base64_encode($this->getApiId() . ':' . $this->getApiPassword())];

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            http_build_query($data)
        );

        return $this->response = $this->createResponse(json_decode($httpResponse->getBody()->getContents(), true));
    }

    /**
     * @return string
     */
    abstract protected function getHttpMethod();

    /**
     * @param array $data
     *
     * @return ResponseInterface
     */
    abstract protected function createResponse(array $data);

}