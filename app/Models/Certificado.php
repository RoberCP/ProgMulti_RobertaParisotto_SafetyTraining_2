<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'carga_horaria',
        'instrutor',
        'progresso',
        'data_emissao',
        'funcionario_id',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }
}

