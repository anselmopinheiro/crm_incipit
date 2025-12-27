<div class="space-y-8">
    <section class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">{{ $account->name }}</h1>
                <p class="text-sm text-gray-500">{{ $account->email_billing ?? 'Sem email de faturação' }}</p>
            </div>
            <div class="text-sm text-gray-500">
                <span class="px-2 py-1 bg-gray-100 rounded">{{ ucfirst($account->status) }}</span>
            </div>
        </div>
        <div class="mt-4 grid md:grid-cols-2 gap-4 text-sm text-gray-600">
            <div>
                <p><span class="font-medium">NIF:</span> {{ $account->vat ?? '—' }}</p>
                <p><span class="font-medium">Telefone:</span> {{ $account->phone ?? '—' }}</p>
                <p><span class="font-medium">Morada:</span> {{ $account->address ?? '—' }}</p>
            </div>
            <div>
                <p><span class="font-medium">Revendedor:</span> {{ optional($account->resellerAccount)->name ?? '—' }}</p>
                <p><span class="font-medium">Observações:</span> {{ $account->observations ?? '—' }}</p>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Serviços e Renovações</h2>
        </div>

        @forelse($groupedTerms as $date => $items)
            <div class="space-y-3">
                <div class="text-sm font-medium text-gray-500">{{ $date }}</div>
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach($items as $item)
                        @php
                            $term = $item['term'];
                            $service = $item['service'];
                        @endphp
                        <div class="bg-white shadow rounded-lg p-5 space-y-2">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold">{{ $term->serviceLabel() }}</h3>
                                <span class="text-xs px-2 py-1 rounded bg-gray-100">{{ ucfirst($term->status) }}</span>
                            </div>
                            <p class="text-sm text-gray-600">
                                @if($item['type'] === 'hosting')
                                    Plano {{ optional($service->plan)->name }} · Início {{ $service->start_date->format('Y-m-d') }}
                                @else
                                    Domínio {{ $service->domain_name }} · Início {{ $service->start_date->format('Y-m-d') }}
                                @endif
                            </p>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Preço aplicado:</span>
                                {{ number_format($term->sale_price_applied, 2, ',', '.') }} €
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium">Documentos:</span>
                                {{ $term->invoice_number ?? '—' }} {{ $term->receipt_number ? ' / ' . $term->receipt_number : '' }}
                            </div>
                            <div class="text-sm">
                                <span class="font-medium">Pago:</span>
                                <span class="{{ $term->paid_at ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $term->paid_at ? 'Sim' : 'Não' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white shadow rounded-lg p-6 text-sm text-gray-500">Sem serviços associados.</div>
        @endforelse
    </section>
</div>
