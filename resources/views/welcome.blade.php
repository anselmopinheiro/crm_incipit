<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM Interno</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow rounded-lg p-8 max-w-lg text-center space-y-4">
            <div>
                <h1 class="text-2xl font-semibold mb-2">CRM Interno</h1>
                <p class="text-sm text-gray-600">Gestão de serviços recorrentes com Livewire.</p>
            </div>
            <div class="grid gap-3 text-sm">
                <a href="{{ route('crm.accounts.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Clientes</a>
                <a href="{{ route('crm.hosting.index') }}" class="px-4 py-2 bg-gray-900 text-white rounded-md">Alojamento</a>
                <a href="{{ route('crm.domains.index') }}" class="px-4 py-2 bg-gray-900 text-white rounded-md">Domínios</a>
            </div>
            <p class="text-xs text-gray-500">Use estas ligações para gerir os registos.</p>
        </div>
    </div>
</body>
</html>
