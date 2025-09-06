<?php
namespace App\Provider;

use Exception;
use GuzzleHttp\Client;

/**
 * Get exchange rates from https://exchangeratesapi.io/
 */
class ExchangeRatesIo
{
    /**
     * Base url of fixer api
     *
     * @var string
     */


    const EXCHANGERATESIO_API_BASEPATH = 'https://api.exchangerate.host/convert';

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * FixerApi constructor.
     * @param Client|null $httpClient
     */
    public function __construct(Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Client();
    }

    /**
     * {@inheritdoc}
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $path = sprintf(
            self::EXCHANGERATESIO_API_BASEPATH . '?symbols=%s&base=%s',
            $toCurrency,
            $fromCurrency
        );
        $result = json_decode($this->httpClient->get($path)->getBody(), true);

        if (!isset($result['rates'][$toCurrency])) {
            throw new Exception(sprintf('Undefined rate for "%s" currency.', $toCurrency));
        }

        return $result['rates'][$toCurrency];
    }
}
