<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        body { font-family: sans-serif; }
        .container { text-align: center; padding: 50px; border: 1px solid #ccc; }
        .titulo { font-size: 24px; font-weight: bold; margin-bottom: 20px; }
        .texto { font-size: 16px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="titulo">Certificado de Conclusão</div>
        <div class="texto">
            Certificamos que <strong>{{ $certificado->funcionario->nome }}</strong> concluiu o curso
            <strong>{{ $certificado->curso->nomeCurso }}</strong> com carga horária de
            <strong>{{ $certificado->carga_horaria }} horas</strong> sob a instrução de
            <strong>{{ $certificado->instrutor }}</strong>.
        </div>
        <div class="texto">
            Data de emissão: {{ \Carbon\Carbon::parse($certificado->dataEmissao)->format('d/m/Y') }}
        </div>
    </div>
</body>
<footer>
    @if ($certificado->assinatura_instrutor)
        <div style="margin-top: 30px;">
            <p>Assinatura do Instrutor:</p>
            <img src="{{ public_path('assinaturas/instrutor.png') }}" alt="Assinatura Instrutor" style="height: 80px;">
        </div>
    @endif

    @if ($certificado->assinatura_funcionario)
        <div style="margin-top: 30px;">
            <p>Assinatura do Funcionário:</p>
            <img src="{{ public_path('assinaturas/funcionario.png') }}" alt="Assinatura Funcionário" style="height: 80px;">
        </div>
    @endif
</html>
