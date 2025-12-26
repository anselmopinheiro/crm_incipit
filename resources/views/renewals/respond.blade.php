<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Renovação de Serviço</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="max-w-3xl mx-auto py-12 px-6">
        <div class="bg-white shadow rounded-lg p-8">
            <h1 class="text-2xl font-semibold mb-4">Renovação do serviço</h1>
            <p class="text-sm text-gray-600 mb-6">
                {{ optional($renewalRequest->recipientAccount)->name }} · {{ optional($renewalRequest->serviceTerm)->serviceLabel() }} · Termina em {{ optional(optional($renewalRequest->serviceTerm)->period_end)->format('Y-m-d') }}
            </p>

            <form method="POST" action="{{ route('renewals.respond.submit', $renewalRequest->token) }}" class="space-y-4">
                @csrf
                <div class="grid gap-3">
                    <label class="flex items-center gap-3 p-3 border rounded-md">
                        <input type="radio" name="response" value="renew_yes" class="text-blue-600" required>
                        <span>Quero renovar</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 border rounded-md">
                        <input type="radio" name="response" value="renew_no" class="text-blue-600" required>
                        <span>Não quero renovar</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 border rounded-md">
                        <input type="radio" name="response" value="contact_me" class="text-blue-600" required>
                        <span>Quero ser contactado</span>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notas (opcional)</label>
                    <textarea name="response_notes" rows="4" class="w-full border rounded-md p-3"></textarea>
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md">
                    Enviar resposta
                </button>
            </form>
        </div>
    </div>
</body>
</html>
