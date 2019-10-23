<?php 
namespace App\Repositories;

use App\Models\SocialNetwork;
use App\Repositories\TraitRepository;

class SocialNetworkRepository 
{
    use TraitRepository;

    /* 
    * Atualizar as redes sociais de um deputado
    */ 
    public function updateSocialNetworks($deputy_id)
    {
        try{
            //Espera de 1 segundo para não sobrecarregar a API 
            sleep(1);
            //Consumindo os dados de um deputado
            $response = $this->client->request( 'GET', 'ws/deputados/'.$deputy_id);
            //Convertendo os dados de XML para string contendo a representação JSON
            $deputy_json_string = json_encode(simplexml_load_string($response->getBody()->getContents()));
            //Convertendo a string em um JSON
            $deputy = json_decode( $deputy_json_string );
            
            //Verifica se a requisição foi realizada com sucesso
            if($response->getStatusCode() == 200){
                //Se existir redes sociais ele salva ou atualiza na tabela social_networks
                if(isset($deputy->redesSociais->redeSocialDeputado)){
                    
                    $deputies_social_networks = $deputy->redesSociais->redeSocialDeputado;
                    
                    if($deputies_social_networks != null){
                        if(is_array($deputies_social_networks)){
                            foreach($deputies_social_networks as $social_network){
                                
                                SocialNetwork::updateOrCreate([
                                    'name'      => $social_network->redeSocial->nome,
                                    'deputy_id' => $deputy_id
                                ]);
                            }
                        }else{
                            
                            SocialNetwork::updateOrCreate([
                                'name'      => $deputies_social_networks->redeSocial->nome,
                                'deputy_id' => $deputy_id
                            ]);
                        }
                    }
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