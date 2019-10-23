<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SocialNetwork;
use DB;
use Illuminate\Support\Facades\Cache;

class SocialNetworkController extends Controller
{
    private $social_network;
    private $minutes = 60;

    public function __construct()
    {
        $this->social_network = new SocialNetwork;
    }

    /* 
    * Retorna uma lista com o Ranking das redes sociais mais utilizadas 
    * dentre os deputados, ordenado de forma decrescente
    */
    public function listRanking()
    {
        //Armazenando em cache por 1h, o ranking das redes sociais
        $ranking = Cache::remember('ranking', $this->minutes, function () {
            return $this->social_network->select('name', DB::raw('count(*) as total'))
                                        ->groupBy('name')
                                        ->orderBy('total','desc')
                                        ->get();
        });   

        return response()->json($ranking);
    }
}
