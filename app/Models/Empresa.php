<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = ['razao_social', 'cnpj', 'ramo'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
