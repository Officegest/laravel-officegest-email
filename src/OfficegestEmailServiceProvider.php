<?php
namespace OfficegestEmail;
use Illuminate\Support\ServiceProvider;
class OfficegestEmailServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //nothing to include
    }
    public function register()
    {
        // Register the config publish path
        $configPath = __DIR__ . '/config/officegest-email.php';
        $this->mergeConfigFrom($configPath, 'officegest-email');
        $this->publishes([$configPath => config_path('officegest-email.php')], 'config');
    }
}
