<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\DomainService;
use App\Models\EmailTemplate;
use App\Models\HostingPlan;
use App\Models\HostingPlanPrice;
use App\Models\HostingService;
use App\Models\NotificationSetting;
use App\Models\ServiceTerm;
use App\Models\Tld;
use App\Models\TldPrice;
use App\Models\User;
use App\Support\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $internalAccount = Account::query()->create([
            'name' => 'Incipit CRM',
            'status' => 'active',
            'email_billing' => 'financeiro@incipit.test',
            'observations' => 'Conta interna.',
        ]);

        $resellerAccount = Account::query()->create([
            'name' => 'Reseller Web',
            'status' => 'active',
            'email_billing' => 'reseller@cliente.test',
        ]);

        $clientAccount = Account::query()->create([
            'name' => 'Cliente Alpha',
            'status' => 'active',
            'email_billing' => 'alpha@cliente.test',
            'reseller_account_id' => $resellerAccount->id,
        ]);

        $directClient = Account::query()->create([
            'name' => 'Cliente Beta',
            'status' => 'active',
            'email_billing' => 'beta@cliente.test',
        ]);

        $admin = User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@incipit.test',
            'password' => Hash::make('password'),
            'role' => Role::ADMIN,
            'account_id' => $internalAccount->id,
        ]);

        User::query()->create([
            'name' => 'Manager',
            'email' => 'manager@incipit.test',
            'password' => Hash::make('password'),
            'role' => Role::MANAGER,
            'account_id' => $internalAccount->id,
        ]);

        User::query()->create([
            'name' => 'Reseller',
            'email' => 'reseller@cliente.test',
            'password' => Hash::make('password'),
            'role' => Role::RESELLER,
            'account_id' => $resellerAccount->id,
        ]);

        User::query()->create([
            'name' => 'Cliente Alpha',
            'email' => 'alpha@cliente.test',
            'password' => Hash::make('password'),
            'role' => Role::CLIENT,
            'account_id' => $clientAccount->id,
        ]);

        User::query()->create([
            'name' => 'Cliente Beta',
            'email' => 'beta@cliente.test',
            'password' => Hash::make('password'),
            'role' => Role::CLIENT,
            'account_id' => $directClient->id,
        ]);

        $hostingPlan = HostingPlan::query()->create([
            'name' => 'Plano Start',
            'capacity_gb' => 10,
            'email_count' => 20,
            'public_description' => 'Ideal para pequenas empresas.',
            'active' => true,
        ]);

        HostingPlanPrice::query()->create([
            'hosting_plan_id' => $hostingPlan->id,
            'purchase_price' => 35,
            'sale_price' => 60,
            'valid_from' => now()->subYear(),
            'created_by' => $admin->id,
        ]);

        $tld = Tld::query()->create([
            'tld' => '.pt',
            'active' => true,
        ]);

        TldPrice::query()->create([
            'tld_id' => $tld->id,
            'purchase_price' => 8,
            'sale_price' => 15,
            'valid_from' => now()->subYear(),
            'created_by' => $admin->id,
        ]);

        $hostingService = HostingService::query()->create([
            'account_id' => $clientAccount->id,
            'hosting_plan_id' => $hostingPlan->id,
            'start_date' => now()->subMonths(10),
            'renewal_date' => now()->addDays(20),
            'discount_percent' => 10,
            'status' => 'active',
        ]);

        $domainService = DomainService::query()->create([
            'account_id' => $directClient->id,
            'domain_name' => 'exemplo.pt',
            'tld_id' => $tld->id,
            'start_date' => now()->subMonths(6),
            'renewal_date' => now()->addDays(15),
            'status' => 'active',
        ]);

        ServiceTerm::query()->create([
            'service_type' => 'hosting',
            'service_id' => $hostingService->id,
            'period_start' => now()->subMonths(10),
            'period_end' => now()->addDays(20),
            'purchase_price_applied' => 35,
            'sale_price_applied' => 60,
            'discount_applied' => 10,
            'status' => 'pending_confirmation',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        ServiceTerm::query()->create([
            'service_type' => 'domain',
            'service_id' => $domainService->id,
            'period_start' => now()->subMonths(6),
            'period_end' => now()->addDays(15),
            'purchase_price_applied' => 8,
            'sale_price_applied' => 15,
            'status' => 'pending_confirmation',
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        NotificationSetting::query()->firstOrCreate([], [
            'internal_notify_days_before' => 30,
            'customer_notify_days_before' => 30,
            'resend_every_days' => 5,
            'max_resends' => 6,
        ]);

        EmailTemplate::query()->create([
            'key' => 'renewal_request',
            'subject' => 'Renovação do serviço {{service_label}}',
            'body' => '<p>Olá {{account_name}},</p><p>O serviço {{service_label}} termina em {{period_end}}.</p><p>Responda aqui: <a href="{{response_url}}">{{response_url}}</a></p>',
            'active' => true,
        ]);

        EmailTemplate::query()->create([
            'key' => 'renewal_summary',
            'subject' => 'Resumo de renovações pendentes',
            'body' => '<p>Renovações na janela:</p>{{items}}',
            'active' => true,
        ]);

        EmailTemplate::query()->create([
            'key' => 'renewal_response',
            'subject' => 'Resposta recebida para {{service_label}}',
            'body' => '<p>Conta: {{account_name}}</p><p>Resposta: {{response}}</p><p>Notas: {{response_notes}}</p>',
            'active' => true,
        ]);
    }
}
