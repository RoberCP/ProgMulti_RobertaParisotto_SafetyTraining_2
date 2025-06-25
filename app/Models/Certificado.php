<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $primaryKey = 'idCertificado';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'idCurso',
        'idFuncionario',
        'dataEmissao',
        'carga_horaria',
        'instrutor',
        'progresso',
        'assinatura_instrutor',
        'assinatura_funcionario',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'idCurso', 'IdCurso');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'idFuncionario', 'idFuncionario');
    }
}
