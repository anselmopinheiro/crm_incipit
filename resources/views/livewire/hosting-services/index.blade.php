<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Alojamento</h1>
        <a href="{{ route('hosting-services.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Novo serviço</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Plano</th>
                    <th class="px-4 py-3 text-left">Renovação</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($services as $service)
                    <tr>
                        <td class="px-4 py-3">{{ optional($service->account)->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ optional($service->plan)->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $service->renewal_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">{{ ucfirst($service->status) }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('hosting-services.edit', $service) }}" class="text-sm text-gray-700">Editar</a>
                            <button type="button" wire:click="delete('{{ $service->id }}')" class="text-sm text-red-600">Remover</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Sem serviços.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $services->links() }}
    </div>
</div>
