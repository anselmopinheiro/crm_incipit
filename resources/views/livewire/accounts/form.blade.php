<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">{{ $account->exists ? 'Editar cliente' : 'Novo cliente' }}</h1>
        <a href="{{ route('accounts.index') }}" class="text-sm text-gray-600">Voltar</a>
    </div>

    <form wire:submit.prevent="save" class="bg-white shadow rounded-lg p-6 space-y-4">
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" wire:model.defer="name" class="mt-1 w-full border rounded-md p-2">
                @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email faturação</label>
                <input type="email" wire:model.defer="email_billing" class="mt-1 w-full border rounded-md p-2">
                @error('email_billing') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">NIF</label>
                <input type="text" wire:model.defer="vat" class="mt-1 w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Telefone</label>
                <input type="text" wire:model.defer="phone" class="mt-1 w-full border rounded-md p-2">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Morada</label>
                <input type="text" wire:model.defer="address" class="mt-1 w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Revendedor</label>
                <select wire:model.defer="reseller_account_id" class="mt-1 w-full border rounded-md p-2">
                    <option value="">Sem revendedor</option>
                    @foreach($resellers as $reseller)
                        <option value="{{ $reseller->id }}">{{ $reseller->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.defer="status" class="mt-1 w-full border rounded-md p-2">
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Observações</label>
                <textarea wire:model.defer="observations" rows="3" class="mt-1 w-full border rounded-md p-2"></textarea>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Guardar</button>
        </div>
    </form>
</div>
