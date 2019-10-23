<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deputy;

class IndemnityAmount extends Model
{
    protected $fillable = ["deputy_id", "amount"];

    public function deputy()
    {
        return $this->belongsTo(Deputy::class);
    }
}
