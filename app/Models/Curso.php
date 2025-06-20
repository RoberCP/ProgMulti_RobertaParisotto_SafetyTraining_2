<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $primaryKey = 'IdCurso';

    protected $fillable = [
        'nomeCurso',
        'cargaHora',
        'instrutor',
        'prazoRecicla',
        'status',
        'empresa_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function funcionarios()
    {
        return $this->belongsToMany(Funcionario::class, 'curso_funcionario', 'curso_id', 'funcionario_id');
    }
}
