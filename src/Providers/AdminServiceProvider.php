<?php

namespace EldoMagan\BagistoArcade\Providers;

use EldoMagan\BagistoArcade\Middlewares\AllowSameOriginIframe;
use EldoMagan\BagistoArcade\ThemeEditor;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'arcade');

        $this->bootMiddlewares();
        $this->bootRequestMacros();
        $this->bootViewEventListeners();

        if ($this->app->runningInConsole()) {
            $this->publishAssets();
        }
    }

    public function register()
    {
        $this->registerConfigs();

        $this->app->singleton(ThemeEditor::class, function ($app) {
            return new ThemeEditor();
        });
    }

    protected function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/admin-menu.php', 'menu.admin');
    }

    protected function publishAssets()
    {
        $this->publishes([
            __DIR__ . '/../../dist/admin' => public_path('vendor/arcade/admin'),
            __DIR__ . '/../../dist/theme-editor' => public_path('vendor/arcade/theme-editor'),
        ], 'public');
    }

    protected function bootRequestMacros()
    {
        Request::macro('inDesignMode', [ThemeEditor::class, 'inDesignMode']);
        Request::macro('inPreviewMode', [ThemeEditor::class, 'inPreviewMode']);
    }

    protected function bootMiddlewares()
    {
        $kernel = $this->app[Kernel::class];
        $kernel->prependMiddleware(AllowSameOriginIframe::class);
    }

    protected function bootViewEventListeners()
    {
        Event::listen('bagisto.admin.layout.head', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('arcade::admin.layouts.style');
        });
    }
}
