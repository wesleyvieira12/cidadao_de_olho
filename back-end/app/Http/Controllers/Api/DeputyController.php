<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deputy;
use App\Models\IndemnityAmount;
use Illuminate\Support\Facades\Cache;

class DeputyController extends Controller
{
    private $deputy;
    private $minutes = 60;

    public function __construct()
    {
        $this->deputy = new Deputy;
    }

    /* 
    * Retorna uma lista com o top 5 deputados que mais pediram reembolso 
    * de verbas indenizatorias por mês no ano de 2019
    */
    public function listTopFive()
    {
        //Armazenando em cache por 1h, o top 5 deputados que mais pediram reembolso
        $deputies_top = Cache::remember('deputies_top', $this->minutes, function () {
            return IndemnityAmount::orderBy('amount','desc')->take(5)->get()->load('deputy');
        });   

        return response()->json($deputies_top);
    }
}
