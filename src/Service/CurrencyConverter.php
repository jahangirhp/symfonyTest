<?php

namespace App\Service;

use App\Provider\ExchangeRatesIo;
;

class CurrencyConverter
{
    /**
     * store cache or not
     *
     * @var bool
     */
    protected bool $cachable = false;


    protected $rateProvider;

      protected $cacheAdapter;

    /**
     * {@inheritDoc}
     */
    public function convert($from, $to, $amount = 1): float
    {
        $fromCurrency = $this->parseCurrencyArgument($from);
        $toCurrency = $this->parseCurrencyArgument($to);

//        if ($this->isCacheable()) {
//            if ($this->getCacheAdapter()->cacheExists($fromCurrency, $toCurrency)) {
//                return $this->getCacheAdapter()->getRate($fromCurrency, $toCurrency) * $amount;
//            } elseif ($this->getCacheAdapter()->cacheExists($toCurrency, $fromCurrency)) {
//                return (1 / $this->getCacheAdapter()->getRate($toCurrency, $fromCurrency)) * $amount;
//            }
//        }
//
//        $rate = $this->getRateProvider()->getRate($fromCurrency, $toCurrency);

          $ex=new ExchangeRatesIo();
          $rate=$ex->getRate($fromCurrency,$to);
//        if ($this->isCacheable()) {
//            $this->getCacheAdapter()->createCache($fromCurrency, $toCurrency, $rate);
//        }

        return $rate * $amount;
    }

    /**
     * Sets if caching is to be enables
     *
     * @param  boolean $cachable
     * @return self
     */
    public function setCachable($cachable = true)
    {
        $this->cachable = (bool) $cachable;

        return $this;
    }

    /**
     * Checks if caching is enabled
     *
     * @return bool
     */
    public function isCacheable()
    {
        return $this->cachable;
    }

    /**
     * Gets Rate Provider
     *
     * @return App\Provider\ProviderInterface
     */
    public function getRateProvider()
    {
        if (!$this->rateProvider) {
            $this->setRateProvider(new ExchangeRatesIo());
        }

        return $this->rateProvider;
    }

    /**
     * Sets rate provider
     *
     * @param  App\Provider\ProviderInterface $rateProvider
     * @return self
     *
     */
    public function setRateProvider(App\Provider\ProviderInterface $rateProvider)
    {
        $this->rateProvider = $rateProvider;

        return $this;
    }

    /**
     * Sets cache adapter
     *
     * @param  Cache\Adapter\CacheAdapterInterface $cacheAdapter
     * @return self
     */
    public function setCacheAdapter(Cache\Adapter\CacheAdapterInterface $cacheAdapter)
    {
        $this->setCachable(true);
        $this->cacheAdapter = $cacheAdapter;

        return $this;
    }

    /**
     * Gets cache adapter
     *
     * @return Cache\Adapter\CacheAdapterInterface
     */
    public function getCacheAdapter()
    {
        if (!$this->cacheAdapter) {
            $this->setCacheAdapter(new Cache\Adapter\FileSystem());
        }

        return $this->cacheAdapter;
    }

    /**
     * Parses the Currency Arguments
     *
     * @param string|array $data
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    protected function parseCurrencyArgument($data)
    {
        if (is_string($data)) {
            $currency = $data;
          } else {
            throw new Exception('Invalid currency provided. String expected.');
        }

        return $currency;
    }
}
