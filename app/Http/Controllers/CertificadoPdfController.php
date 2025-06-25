<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoPdfController extends Controller
{
    public function gerar($id)
    {
        $certificado = Certificado::with(['curso', 'funcionario'])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.certificado', compact('certificado'));
        return $pdf->download('certificado_' . $certificado->funcionario->nome . '.pdf');
    }
}

