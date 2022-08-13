<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\TransferStock;
use App\Observers\BrandObserver;
use App\Observers\ProductObserver;
use App\Observers\StoreObserver;
use App\Observers\SupplierObserver;
use App\Observers\TransferStockObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(ProductObserver::class);
        Brand::observe(BrandObserver::class);
        Supplier::observe(SupplierObserver::class);
        Store::observe(StoreObserver::class);
        TransferStock::observe((TransferStockObserver::class));
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
