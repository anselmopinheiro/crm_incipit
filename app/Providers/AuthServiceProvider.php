<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Account;
use App\Models\DomainService;
use App\Models\EmailTemplate;
use App\Models\HostingPlan;
use App\Models\HostingPlanPrice;
use App\Models\HostingService;
use App\Models\NotificationSetting;
use App\Models\RenewalRequest;
use App\Models\ServiceTerm;
use App\Models\Tld;
use App\Models\TldPrice;
use App\Policies\AccountPolicy;
use App\Policies\DomainServicePolicy;
use App\Policies\EmailTemplatePolicy;
use App\Policies\HostingPlanPolicy;
use App\Policies\HostingPlanPricePolicy;
use App\Policies\HostingServicePolicy;
use App\Policies\NotificationSettingPolicy;
use App\Policies\RenewalRequestPolicy;
use App\Policies\ServiceTermPolicy;
use App\Policies\TldPolicy;
use App\Policies\TldPricePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Account::class => AccountPolicy::class,
        HostingPlan::class => HostingPlanPolicy::class,
        HostingPlanPrice::class => HostingPlanPricePolicy::class,
        Tld::class => TldPolicy::class,
        TldPrice::class => TldPricePolicy::class,
        HostingService::class => HostingServicePolicy::class,
        DomainService::class => DomainServicePolicy::class,
        ServiceTerm::class => ServiceTermPolicy::class,
        RenewalRequest::class => RenewalRequestPolicy::class,
        NotificationSetting::class => NotificationSettingPolicy::class,
        EmailTemplate::class => EmailTemplatePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
