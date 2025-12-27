<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Domínios</h1>
        @can('create', \App\Models\DomainService::class)
            <a href="{{ route('crm.domains.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Novo domínio</a>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Domínio</th>
                    <th class="px-4 py-3 text-left">Renovação</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($services as $service)
                    <tr>
                        <td class="px-4 py-3">{{ optional($service->account)->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $service->domain_name }}</td>
                        <td class="px-4 py-3">{{ $service->renewal_date->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">{{ ucfirst($service->status) }}</td>
                        <td class="px-4 py-3 text-right">
                            @can('update', $service)
                                <a href="{{ route('crm.domains.edit', $service) }}" class="text-sm text-gray-700">Editar</a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Sem domínios.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $services->links() }}
    </div>
</div>
