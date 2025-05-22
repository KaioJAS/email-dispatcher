<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4">
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">
                    Dashboard do Email Dispatcher
                </h1>
                <p class="text-gray-600 mb-6">
                    Sistema de gerenciamento de disparos de e-mail funcionando!
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-900">Emails Enviados</h3>
                        <p class="text-2xl font-bold text-blue-600">0</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-green-900">Em Fila</h3>
                        <p class="text-2xl font-bold text-green-600">0</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-red-900">Com Erro</h3>
                        <p class="text-2xl font-bold text-red-600">0</p>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="/" class="text-blue-600 hover:text-blue-800">
                        ← Voltar para o login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>