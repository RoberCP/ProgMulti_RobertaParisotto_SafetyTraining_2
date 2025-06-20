<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $primaryKey = 'idFuncionario';

    protected $fillable = [
        'idEmpresa',
        'nome',
        'cpf',
        'setor',
        'cargo',
        'fk_Certificado_idCertificado',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'idEmpresa');
    }

    public function certificado()
    {
        return $this->belongsTo(Certificado::class, 'fk_Certificado_idCertificado');
    }
}
