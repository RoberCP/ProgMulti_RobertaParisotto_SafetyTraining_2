<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoPdfController extends Controller
{
    public function gerar($id)
    {
        $certificado = Certificado::with(['curso', 'funcionario'])->findOrFail($id);

        $pdf = Pdf::loadView('certificado.pdf', [
            'certificado' => $certificado,
            'assinaturaInstrutor' => $certificado->assinatura_instrutor_base64,
            'assinaturaFuncionario' => $certificado->assinatura_funcionario_base64,
        ]);

        return $pdf->stream("certificado_{$certificado->idCertificado}.pdf");
    }
}
