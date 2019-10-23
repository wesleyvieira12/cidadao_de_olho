<?php
namespace App\Repositories;

use App\Models\IndemnityAmount;
use App\Repositories\TraitRepository;

class IndemnityAmountRepository
{
    use TraitRepository;

    /* 
    * Atualiza a tabela de montante de indenizações reembolsadas
    */
    public function updateIndemnityAmount($deputy_id)
    {
        try{
            //Espera de 1 segundo para não sobrecarregar a API 
            sleep(1);
            //Consumindo datas fechadas para verbas indenizatórias na legislatura atual de um Deputado
            $response = $this->client->request( 'GET', 'ws/prestacao_contas/verbas_indenizatorias/legislatura_atual/deputados/'.$deputy_id.'/datas');
            //Convertendo os dados de XML para string contendo a representação JSON
            $dates_json_string = json_encode(simplexml_load_string($response->getBody()->getContents()));
            //Convertendo a string em um JSON
            $dates = json_decode( $dates_json_string );
            
            //Verifica se a requisição foi realizada com sucesso
            if( $response->getStatusCode() == 200 ){

                if(isset($dates->fechamentoVerba)){
                    if(is_array($dates->fechamentoVerba)){
                        $total = 0;
                        /*
                        * Percorre todas as datas, e verifica se é do ano de 2019, caso seja calcula o
                        * montante total daquele deputado, somente para datas com ano de 2019
                        */
                        foreach($dates->fechamentoVerba as $date){

                            $ano = explode("-",$date->dataReferencia)[0];
                            if($ano === "2019"){
                                $total += $this->searchAmountsByDate($date->dataReferencia,$deputy_id);
                            }
                        }

                        /*
                        * Verifica se existe um montante para o deputado informado,
                        * caso tenha ele só atualiza esse valor, caso não tenha ele cria o montante
                        * de verbas reembolsadas
                        */
                        
                        $indemnity_amount = IndemnityAmount::where('deputy_id',$deputy_id)->first();
                        if($indemnity_amount == null){
                            IndemnityAmount::create([
                                "deputy_id" => $deputy_id, 
                                "amount"    => $total
                            ]);
                        }else{
                            $indemnity_amount->amount = $total;
                            $indemnity_amount->save();
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

    /* 
    * Busca os montantes por data e retorna o valor total das verbas reembolsadas
    */    
    public function searchAmountsByDate($date,$deputy_id)
    {   
        //Transformando data para o formato "Y/m"
        $date = substr(str_replace("-","/",$date),0,-3);
        try{
            //Espera de 1 segundo para não sobrecarregar a API 
            sleep(1);
            //Consumindo verbas indenizatorias de um deputado em uma data especifica
            $response = $this->client->request( 'GET', 
                                                'ws/prestacao_contas/verbas_indenizatorias/legislatura_atual/deputados/'
                                                .$deputy_id.'/'.$date);
            //Convertendo os dados de XML para string contendo a representação JSON
            $response_json_string = json_encode(simplexml_load_string($response->getBody()->getContents()));
            //Convertendo a string em um JSON
            $responses = json_decode( $response_json_string );
            $total = 0;

            //Verifica se a requisição foi realizada com sucesso
            if( $response->getStatusCode() == 200 ){
                /* 
                * Verifica se existe um array de verbas, se existir pega cada valor reembolsado
                * e adiciona a uma variavel $total
                */ 
                if(is_array($responses->resumoVerba)){
                    foreach($responses->resumoVerba as $founds){
                        if(is_array($founds->listaDetalheVerba->detalheVerba)){
                            foreach($founds->listaDetalheVerba->detalheVerba as $found){
                                $total += intval($found->valorReembolsado);
                            }
                        } 
                    }
                }else{
                    if(isset($responses->resumoVerba)){
                        if($responses->resumoVerba != null){
                            if(is_array($responses->resumoVerba->listaDetalheVerba->detalheVerba)){
                                foreach($responses->resumoVerba->listaDetalheVerba->detalheVerba as $found){
                                    $total += intval($found->valorReembolsado);
                                }
                            }else{
                                $total += intval($responses->resumoVerba->listaDetalheVerba->detalheVerba->valorReembolsado);
                            } 
                        }
                    }
                }
                return $total;
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