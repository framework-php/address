<?php

namespace GuilhermeHideki\Core\Address\Providers\Interfaces;

use GuilhermeHideki\Core\Address\Cep;

use Aura\Payload\Payload;

interface CepProvider
{
    /**
     * @param Cep $cep
     *
     * @return Payload
     */
    public function getCep(Cep $cep);
}