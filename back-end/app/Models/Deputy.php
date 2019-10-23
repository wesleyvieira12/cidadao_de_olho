<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SocialNetwork;
use App\Models\IndemnityAmount;

class Deputy extends Model
{
    protected $fillable = ["id","name", "broken"];
    
    public function socialNetworks()
    {
        return $this->hasMany(SocialNetwork::class);
    }

    public function indemnityAmount()
    {
        return $this->hasOne(IndemnityAmount::class);
    }
}
