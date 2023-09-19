<?php

namespace EmployeeCard\Classes;

use DateInterval;
use DateTimeInterface;
use WpFluent\Exception;

class URL
{
    public function current()
    {
        return get_site_url() . rtrim(preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']), '/');
    }

    /**
     * Parse a url from uncompiled route
     *
     * @param string $url
     * @param array $params
     * @return string
     */
    public function parse(string $url, array $params)
    {
        return preg_replace_callback('#\{[a-zA-Z0-9-_]+\}#', function ($matches) use ($params) {
            foreach ($matches as $match) {
                $match = str_replace(['{', '}'], ['', ''], $match);
                if (isset($params[$match])) {
                    return $params[$match];
                }
            }
        }, $url);
    }

    /**
     * Create a signed URL
     *
     * @param string $url
     * @param array $params
     * @param \DateTimeInterface|int|null $expiresAt
     * @return string Signed URL
     */
    public function sign(string $url, array $params, $expiresAt = null)
    {
        return $this->createUrlWithSignature(
            $this->parse($url, $params), $expiresAt
        );

    }

    /**
     * Verify a signed URL
     *
     * @param string $url
     * @return bool
     */
    public function verify($url)
    {
        $parsedUrl = parse_url($url);

        parse_str($parsedUrl['query'], $result);


        $expiresAt = $result['expiresAt']??'';
        $urlSignature = $result['signature']??'';


        $newSignature = $this->getSignature(
            $this->getDigest($parsedUrl['path'], $expiresAt)
        );

        if (!($isValidSignature = hash_equals($urlSignature, $newSignature))) {
            throw new Exception('Invalid Signature.');
        }

        $isExpired = false;

        if ($expiresAt) {
            $now = (new DateTime)->getTimestamp();
            if ($isExpired = $now > $expiresAt) {
                throw new Exception('URL Expired.');
            }
        }

        return $isValidSignature && !$isExpired;
    }

    /**
     * Verify a signed URL
     *
     * @param string $url
     * @return bool
     */
    public function isValidSignedUrl($url)
    {
        try {
            return $this->verify($url);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Create a signed URL
     *
     * @param string $url
     * @param array $params
     * @param \DateTimeInterface|int|null $expiresAt
     * @return string Signed URL
     */
    protected function createUrlWithSignature(string $url, $expiresAt = null)
    {
        $expiresAt = $this->expiresAt($expiresAt);

        $signature = $this->getSignature(
            $this->getDigest($url, $expiresAt)
        );

        return $this->buildUrl($url, $expiresAt, $signature);
    }

    /**
     * Get the "available at" UNIX timestamp.
     *
     * @param \DateTimeInterface|\DateInterval|int $delay
     * @return int
     */
    protected function expiresAt($delay = 0)
    {
        if (is_null($delay)) return $delay;

        $delay = $this->parseDateInterval($delay);

        return $delay instanceof DateTimeInterface
            ? $delay->getTimestamp()
            : DateTime::now()->add(new DateInterval("PT{$delay}S"))->getTimestamp();
    }

    /**
     * If the given value is an interval, convert it to a DateTime instance.
     *
     * @param \DateTimeInterface|\DateInterval|int $delay
     * @return \DateTimeInterface|int
     */
    protected function parseDateInterval($delay)
    {
        if ($delay instanceof DateInterval) {
            $delay = DateTime::now()->add($delay);
        }

        return $delay;
    }

    /**
     * Prepare the digest to sign
     *
     * @param string $url Parsed URL
     * @param \DateTimeInterface|int|null $expiresAt
     * @return string
     */
    protected function getDigest($url, $expiresAt = null)
    {
        if (!$expiresAt) {
            return base64_encode($url);
        } else {
            return base64_encode(rtrim($url) . '/' . $expiresAt);
        }
    }

    /**
     * Generate the signature
     *
     * @param string $digest
     * @return string hash
     */
    protected function getSignature($digest)
    {
        return hash_hmac(
            'sha256',
            $digest,
            '2tDlRd5bpw7A+k4FFKsXj4GPIsYnA05PIA719943BE0='
        );
    }


    /**
     * Build the final url with signature
     *
     * @param string $url
     * @param \DateTimeInterface|int|null $expiresAt
     * @param string $signature hash
     * @return string Final URL
     */
    protected function buildUrl($url, $expiresAt, $signature)
    {
        $queryParams = array_filter(compact('expiresAt', 'signature'));

        $queryString = http_build_query($queryParams);

        return "{$url}?{$queryString}";
    }

    /**
     * Returns the string representation of the URL object
     *
     * @return string Current URL.
     */
    public function __toString()
    {
        return $this->current();
    }
}
