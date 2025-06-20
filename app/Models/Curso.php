<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['idCurso', 'nomeCurso', 'cargaHora', 'instrutor', 'prazoRecicla', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
