<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold">{{ $service->exists ? 'Editar alojamento' : 'Novo alojamento' }}</h1>
        <a href="{{ route('crm.hosting.index') }}" class="text-sm text-gray-600">Voltar</a>
    </div>

    <form wire:submit.prevent="save" class="bg-white shadow rounded-lg p-6 space-y-4">
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Cliente</label>
                <select wire:model.defer="account_id" class="mt-1 w-full border rounded-md p-2">
                    <option value="">Selecionar</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
                @error('account_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Plano</label>
                <select wire:model.defer="hosting_plan_id" class="mt-1 w-full border rounded-md p-2">
                    <option value="">Selecionar</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                    @endforeach
                </select>
                @error('hosting_plan_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Data início</label>
                <input type="date" wire:model.defer="start_date" class="mt-1 w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Data renovação</label>
                <input type="date" wire:model.defer="renewal_date" class="mt-1 w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Desconto (%)</label>
                <input type="number" step="0.01" wire:model.defer="discount_percent" class="mt-1 w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.defer="status" class="mt-1 w-full border rounded-md p-2">
                    <option value="active">Ativo</option>
                    <option value="renewal_pending">Renovação pendente</option>
                    <option value="cancelled">Cancelado</option>
                    <option value="expired">Expirado</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Cancelamento pedido</label>
                <input type="date" wire:model.defer="cancellation_requested_at" class="mt-1 w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Cancelamento confirmado</label>
                <input type="date" wire:model.defer="cancellation_confirmed_at" class="mt-1 w-full border rounded-md p-2">
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
