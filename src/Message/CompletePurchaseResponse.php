<?php

namespace Omnipay\Qiwi\Message;


use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse
    extends AbstractResponse
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
       return array_key_exists('status', $this->data) &&  $this->data['status'] === 'paid';
    }

    /**
     * {@inheritdoc}
     */
    public function isPending()
    {
        return array_key_exists('status', $this->data) &&  $this->data['status'] === 'waiting';
    }

    /**
     * {@inheritdoc}
     */
    public function isCancelled()
    {
        return array_key_exists('status', $this->data) && in_array($this->data['status'], ['rejected', 'unpaid', 'expired'], true);
    }
}