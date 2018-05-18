<?php

namespace GuilhermeHideki\Core\Address\Providers;

use Aura\Payload_Interface\PayloadStatus;
use Aura\Payload\Payload;
use GuilhermeHideki\Core\Address\Address;
use GuilhermeHideki\Core\Address\Cep;
use GuilhermeHideki\Core\Address\Providers\Base\FromUrl;
use GuilhermeHideki\Core\Address\Providers\Interfaces\CepProvider;
use Http\Client\Exception;
use Http\Client\HttpClient;
use Interop\Http\Factory\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;


class ViaCep extends FromUrl implements CepProvider
{
    /**
     * ViaCep constructor.
     *
     * @param HttpClient              $httpClient
     * @param RequestFactoryInterface $requestFactory
     * @param Payload                 $payload
     * @param array                   $url
     */
    public function __construct(
        HttpClient $httpClient,
        RequestFactoryInterface $requestFactory,
        Payload $payload,
        $url = 'http://www.viacep.com.br/ws/{cep}/json/unicode'
    ) {

        parent::__construct(
            $httpClient,
            $requestFactory,
            $payload,
            $url
        );
    }

    /**
     * @param Cep $cep
     *
     * @return Payload|null
     */
    public function getCep(Cep $cep)
    {
        try {
            $response = $this->client->sendRequest($this->buildRequest($cep));
            return $this->processResponse($response, $cep);

        } catch (\Exception $e) { } catch (Exception $e) { }

        return $this->cepNotFound($cep);
    }

    protected function buildRequest(Cep $cep)
    {
        return $this->requestFactory
            ->createRequest('GET', $this->formatUrl($cep));
    }

    /**
     * Undocumented function
     *
     * @param Cep $cep
     * @return string
     */
    protected function formatUrl(Cep $cep)
    {
        return str_replace('{cep}', $cep->getValue(), $this->url);
    }

    /**
     * Process the response from the website
     *
     * @param ResponseInterface $response
     * @param Cep               $cep
     *
     * @return Payload
     */
    protected function processResponse(ResponseInterface $response, Cep $cep)
    {
        try {
            $data = $response->getBody()->getContents();
            var_dump($data);

            if ($response->getStatusCode() !== 200) {
                return $this->cepNotFound($cep);
            }
        } catch (\RuntimeException $e) {
            return $this->cepNotFound($cep);
        }

        $json = json_decode($data, true);
        $address = new Address(
            $json['uf'],
            $json['localidade'],
            $json['bairro'],
            $json['cep'],
            [$json['logradouro'], $json['complemento']]
        );

        $address->ibge = $json['ibge'];

        return $this->payload
            ->setStatus(PayloadStatus::FOUND)
            ->setOutput($address);
    }
}
