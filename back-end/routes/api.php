<?php

//Rotas da API
Route::namespace('Api')->name('api.')->group(function(){
    
    //Rotas dos deputados
    Route::prefix('deputies')->group(function(){
        $this->get('/top-five','DeputyController@listTopFive')->name('deputies.top-five');
    });

    //Rotas das redes sociais
    Route::prefix('social-networks')->group(function(){
        $this->get('/ranking','SocialNetworkController@listRanking')->name('social-networks.ranking'); 
    });
});
