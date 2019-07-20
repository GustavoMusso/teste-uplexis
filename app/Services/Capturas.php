<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Capturas
{
    private $servicoArtigos;
    private $guzzle;

    public function __construct()
    {
        $this->guzzle = new Client();
        $this->servicoArtigos = new Artigos();
    }

    public function buscaArtigos(array $parametro)
    {

    }
    
}