<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $primaryKey = 'idFuncionario';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'idEmpresa',
        'nome',
        'cpf',
        'setor',
        'cargo',
        'curso_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idEmpresa');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'IdCurso');
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'idFuncionario', 'idFuncionario');
    }

}
