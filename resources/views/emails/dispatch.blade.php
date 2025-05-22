<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #667eea;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
            margin: -20px -20px 20px -20px;
        }
        .content {
            padding: 20px 0;
        }
        .footer {
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        h1 {
            margin: 0;
            font-size: 24px;
        }
        .sender-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .content h1, .content h2, .content h3 {
            color: #333;
        }
        .content ul, .content ol {
            padding-left: 20px;
        }
        .content blockquote {
            border-left: 4px solid #667eea;
            padding-left: 15px;
            margin: 15px 0;
            color: #666;
        }
        .content img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 {{ $titulo }}</h1>
        </div>

        <div class="sender-info">
            <strong>De:</strong> {{ $remetente }}
        </div>

        <div class="content">
            {!! $conteudo !!}
        </div>

        <div class="footer">
            <p>Este email foi enviado através do <strong>Email Dispatcher</strong></p>
            <p><small>Sistema de Disparos de Email</small></p>
        </div>
    </div>
</body>
</html>