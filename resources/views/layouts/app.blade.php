<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM Incipit</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="font-semibold text-lg">CRM Interno</div>
                <nav class="flex flex-wrap gap-3 text-sm text-gray-600">
                    <a href="{{ route('accounts.index') }}" class="hover:text-gray-900">Clientes</a>
                    <a href="{{ route('hosting-services.index') }}" class="hover:text-gray-900">Alojamento</a>
                    <a href="{{ route('domain-services.index') }}" class="hover:text-gray-900">Domínios</a>
                </nav>
                <div class="text-sm text-gray-500">Gestão de serviços recorrentes</div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-8">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
