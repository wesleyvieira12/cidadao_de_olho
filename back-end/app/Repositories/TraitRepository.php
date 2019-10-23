<?php
namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

//Será utilizado para reutilizar em todos os repositorios
trait TraitRepository
{
    public $client;

    public function __construct(){
        //Criação de um cliente guzzle
        $this->client = new Client( [
            'headers' => [ 
                'User-Agent' => 'MyReader'
            ],
            'base_uri' => 'http://dadosabertos.almg.gov.br/'
        ] );
        
    }
}