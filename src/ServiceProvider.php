<?php

namespace State\OgGenerator;

use Illuminate\Support\Facades\Event;
use Statamic\Events\EntrySaving;
use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;
use State\OgGenerator\Tags\OgGenerator;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    protected $tags = [
        OgGenerator::class,
    ];

    public function bootAddon()
    {
        // Add Nav To Tools
        Nav::extend(function ($nav) {
            // Determine icon based on Statamic version
            $icon = version_compare(statamic_version(), '6.0.0', '>=') ? 'share' : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m15.543 15.543-2.628-6.571c-.2-.511-.558-.519-.785-.018l-2.087 4.589-1.859-2.231a.667.667 0 0 0-1.155.089l-2.486 4.142"></path><rect width="17" height="17" x="1.543" y="1.543" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" rx="1" ry="1"></rect><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m20.551 7.424 1 .091a1 1 0 0 1 .901 1.085l-1.181 12.948a1 1 0 0 1-1.087.9L6.243 21.18m-4.7-5.637h17"></path><circle cx="6.043" cy="6.043" r="1.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></circle></svg>';

            $item = $nav->tools('OG Generator')
                ->route('og-generator.edit')
                ->icon($icon);

            // Statamic 6 requires a proper "active" handler
            if (version_compare(statamic_version(), '6.0.0', '>=')) {
                $item->active(function ($request) {
                    return $request->routeIs('og-generator.*');
                });
            }
        });

        // Register your event listener
        Event::listen(EntrySaving::class, EntrySavingListener::class);
    }
}
