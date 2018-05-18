<?php

namespace GuilhermeHideki\Core\Address\Providers;

use Aura\Payload_Interface\PayloadStatus;
use Aura\Payload\Payload;
use function GuzzleHttp\Psr7\stream_for;
use GuilhermeHideki\Core\Address\Cep;
use GuilhermeHideki\Core\Address\Address;
use GuilhermeHideki\Core\Address\Providers\Interfaces\CepProvider;
use Http\Client\Exception;
use Http\Client\HttpClient;
use Interop\Http\Factory\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use GuilhermeHideki\Core\Address\Providers\Base\FromUrl;

/**
 * Strategy to fetch the data from Correios
 */
class Correios extends FromUrl
{
    /**
     * CorreiosCepProvider constructor.
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
        $url = 'http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm'
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
     * @return Payload
     */
    public function getCep(Cep $cep)
    {
        /** @var StreamInterface $postData Dados para o request PSR-7 */
        $postData = stream_for(http_build_query([
            'relaxation' => $cep->getValue(),
            'tipoCEP' => 'ALL',
            'semelhante' => 'n'
        ]));

        try {
            $request = $this->requestFactory
                ->createRequest('POST', $this->url)
                ->withBody($postData);

            $response = $this->client->sendRequest($request);

            return $this->processResponse($response, $cep);
        } catch (\Exception $e) {} catch (Exception $e) {}

        return $this->cepNotFound($cep);
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

            if ($response->getStatusCode() !== 200 || preg_match('/NAO ENCONTRADO/', $data)) {
                return $this->cepNotFound($cep);
            }
        } catch (\RuntimeException $e) {
            return $this->cepNotFound($cep);
        }

        return $this->payload
            ->setStatus(PayloadStatus::FOUND)
            ->setOutput($data);
    }
}