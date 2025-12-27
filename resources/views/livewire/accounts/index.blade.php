<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Clientes</h1>
        <a href="{{ route('accounts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Novo cliente</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">Nome</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($accounts as $account)
                    <tr>
                        <td class="px-4 py-3">
                            <a href="{{ route('accounts.show', $account) }}" class="text-blue-600">{{ $account->name }}</a>
                        </td>
                        <td class="px-4 py-3">{{ $account->email_billing ?? '—' }}</td>
                        <td class="px-4 py-3">{{ ucfirst($account->status) }}</td>
                        <td class="px-4 py-3 text-right space-x-3">
                            <a href="{{ route('accounts.edit', $account) }}" class="text-sm text-gray-700">Editar</a>
                            <button type="button" wire:click="delete('{{ $account->id }}')" class="text-sm text-red-600">Remover</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Sem clientes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $accounts->links() }}
    </div>
</div>
