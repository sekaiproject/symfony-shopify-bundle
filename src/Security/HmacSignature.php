<?php

namespace CodeCloud\Bundle\ShopifyBundle\Security;

class HmacSignature
{
    /**
     * @var string
     */
    private $sharedSecret;

    /**
     * @param string $sharedSecret
     */
    public function __construct(string $sharedSecret)
    {
        $this->sharedSecret = $sharedSecret;
    }

    /**
     * Check if the signature is correct.
     *
     * @param string $signature
     * @param array  $params
     *
     * @return bool
     */
    public function isValid($signature, array $params)
    {
        return $this->generateHmac($params) === $signature;
    }

    /**
     * Generate parameters to be used to authenticate subsequent requests.
     *
     * @param string $storeName
     *
     * @return array
     */
    public function generateParams($storeName)
    {
        $timestamp = time();

        return [
            'shop' => (string) $storeName,
            'timestamp' => $timestamp,
            'hmac' => $this->generateHmac([
                'shop' => (string) $storeName,
                'timestamp' => $timestamp,
            ]),
        ];
    }

    /**
     * @param array $params
     *
     * @return string
     */
    private function generateHmac($params)
    {
        $signatureParts = [];

        foreach ($params as $key => $value) {
            if (in_array($key, ['signature', 'hmac'])) {
                continue;
            }

            $signatureParts[] = $key.'='.$value;
        }

        natsort($signatureParts);

        return hash_hmac('sha256', implode('&', $signatureParts), $this->sharedSecret);
    }
}
