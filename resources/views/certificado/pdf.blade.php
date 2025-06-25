<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            color: #222;
            padding: 60px;
            border: 10px solid #4CAF50;
            margin: 40px auto;
            width: 90%;
            max-width: 800px;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 40px;
            color: #4CAF50;
        }

        .texto {
            font-size: 18px;
            line-height: 1.8;
            text-align: justify;
        }

        .destaque {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 40px 0 20px;
            color: #000;
        }

        .assinaturas {
            margin-top: 80px;
            display: flex;
            justify-content: space-around;
        }

        .assinatura {
            text-align: center;
            width: 40%;
        }

        .assinatura img {
            width: 180px;
            height: auto;
            border-bottom: 1px solid #888;
            margin-bottom: 5px;
        }

        .label {
            font-size: 14px;
            margin-top: 4px;
        }

        .data {
            text-align: center;
            margin-top: 40px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <h1>Certificado de Conclusão</h1>

    <div class="texto">
        Certificamos que <span class="destaque">{{ $certificado->funcionario->nome ?? 'N/A' }}</span> concluiu com êxito o curso <strong>{{ $certificado->curso->nomeCurso ?? 'N/A' }}</strong>, com carga horária de <strong>{{ $certificado->carga_horaria }}</strong> horas, ministrado por <strong>{{ $certificado->instrutor }}</strong>.
    </div>

    <div class="data">
        {{ \Carbon\Carbon::parse($certificado->dataEmissao)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}
    </div>

    <div class="assinaturas">
        @if($certificado->assinatura_instrutor_base64)
            <div class="assinatura">
                <img src="{!! $certificado->assinatura_instrutor_base64 !!}">
                <div class="label">Assinatura do Instrutor</div>
            </div>
        @endif

        @if($certificado->assinatura_funcionario_base64)
            <div class="assinatura">
                <img src="{!! $certificado->assinatura_funcionario_base64 !!}">
                <div class="label">Assinatura do Funcionário</div>
            </div>
        @endif
    </div>

</body>
</html>
