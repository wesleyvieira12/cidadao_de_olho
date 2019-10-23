<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deputy;

class SocialNetwork extends Model
{
    protected $fillable = ["name","deputy_id"];

    public function deputy()
    {
        return $this->belongsTo(Deputy::class);
    }
}
