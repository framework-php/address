<?php

namespace GuilhermeHideki\Core\Address\Providers\Base;

use Aura\Payload\Payload;
use Aura\Payload_Interface\PayloadStatus;
use GuilhermeHideki\Core\Address\Cep;
use GuilhermeHideki\Core\Address\Providers\Interfaces\CepProvider;
use Http\Client\HttpClient;
use Interop\Http\Factory\RequestFactoryInterface;

abstract class FromUrl implements CepProvider
{
    CONST CEP_NOT_FOUND = 'CEP %s não foi encontrado';

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var Payload
     */
    protected $payload;

    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;

    /**
     * @var string
     */
    protected $url;

    /**
     * Default constructor.
     *
     * @param HttpClient              $httpClient
     * @param RequestFactoryInterface $requestFactory
     * @param Payload                 $payload
     * @param string                  $url
     */
    public function __construct(
        HttpClient $httpClient,
        RequestFactoryInterface $requestFactory,
        Payload $payload,
        $url
    ) {
        $this->client = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->payload = $payload;
        $this->url = $url;
    }

    /**
     * @param Cep $cep
     *
     * @return Payload
     */
    abstract public function getCep(Cep $cep);


    /**
     * Helper method
     *
     * @param Cep $cep
     *
     * @return Payload
     */
    protected function cepNotFound(Cep $cep)
    {
        return $this->payload
            ->setStatus(PayloadStatus::NOT_FOUND)
            ->setOutput(sprintf(self::CEP_NOT_FOUND, $cep->getValue()));
    }
}