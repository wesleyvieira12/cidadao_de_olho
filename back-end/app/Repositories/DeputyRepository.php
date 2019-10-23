<?php
namespace App\Repositories;

use App\Models\Deputy;
use App\Repositories\TraitRepository;
use App\Repositories\SocialNetworkRepository;

class DeputyRepository
{
    use TraitRepository;

    /* 
    * Atualiza a tabela de deputados e das redes sociais deles
    */
    public function updateDeputy()
    {
        try{
            //Consumindo os dados dos deputados em exercício na legislatura atual
            $response = $this->client->request( 'GET', 'ws/deputados/em_exercicio');
            //Convertendo os dados de XML para string contendo a representação JSON
            $deputies_json_string = json_encode(simplexml_load_string($response->getBody()->getContents()));
            //Convertendo a string em um JSON
            $deputies = json_decode( $deputies_json_string )->deputado;
                
            //Verifica se a requisição foi realizada com sucesso
            if( $response->getStatusCode() == 200 ){

                //Criando um loop para pegar cada deputado e atualizar a tabela deputies e social_networks
                foreach($deputies as $deputy){

                    $deputy_id = intval($deputy->id);

                    Deputy::updateOrCreate([
                        'id'     => $deputy_id,
                        'name'   => $deputy->nome,
                        'broken' => $deputy->partido
                    ]);
                    
                    $social_network = new SocialNetworkRepository;
                    $social_network->updateSocialNetworks($deputy_id);
                }
            }else{
                echo "\nAlgum erro inesperado ocorreu ao buscar os dados dos deputados na API\n\n";
            }
            
        }catch(RequestException $e){
            echo \GuzzleHttp\Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo \GuzzleHttp\Psr7\str($e->getResponse());
            }
        }catch (ClientException $e){
            echo \GuzzleHttp\Psr7\str($e->getRequest());
            echo \GuzzleHttp\Psr7\str($e->getResponse());
        }
    }
}