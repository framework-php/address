<?php

namespace Tests;

use GuilhermeHideki\Core\Address\Address;
use GuilhermeHideki\Core\Address\Cep;
use GuilhermeHideki\Core\Address\Providers\Interfaces\CepProvider;
use GuilhermeHideki\Core\Address\Providers\ViaCep;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\HttpClient;
use Http\Factory\Diactoros\RequestFactory;
use Interop\Http\Factory\RequestFactoryInterface;
use PHPUnit\Framework\TestCase;

class ViaCepTest extends TestCase
{
    /**
     * @var CepProvider
     */
    protected $strategy;

    public function setUp()
    {
        $injector = new \Auryn\Injector();
        $guzzle = new GuzzleClient([
            // Verify SSL
            'verify' => false,
        ]);

        $adapter = new GuzzleAdapter($guzzle);

        $injector->alias(HttpClient::class, GuzzleAdapter::class);
        $injector->alias(RequestFactoryInterface::class, RequestFactory::class);
        $injector->share($adapter);

        $this->strategy = $injector->make(ViaCep::class);
    }

    public function testSearch()
    {
        $cep = new Cep('01001-000');
        $response = $this->strategy->getCep($cep);

        /** @var Address $address */
        $address = $response->getOutput();

        $this->assertEquals('São Paulo', $address->getLocality());
        $this->assertEquals('Sé', $address->getDependentLocality());
        $this->assertEquals('Sé', $address->getDependentLocality());
    }
}
