<?php

namespace Litstack\Rehearsal;

use Ignite\Support\Facades\Lit;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Orchestra\Testbench\Concerns\CreatesApplication;
use PHPUnit\Framework\TestCase;
use Throwable;

class Installer extends TestCase
{
    use CreatesApplication,
        InteractsWithConsole;

    /**
     * Laravel application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Get environment setup.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Install fjord into orchestra testbench.
     *
     * @return void
     */
    public function install()
    {
        if (! $path = realpath($this->orchestraPath())) {
            return false;
        }

        $this->register(
            $this->app = $this->createApplication()
        );

        if (Lit::installed()) {
            return false;
        }

        try {
            $this->artisan('lit:install');
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }

    /**
     * Register application providers.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function register($app)
    {
        $app->register(\Livewire\LivewireServiceProvider::class);
        $app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);
        $app->register(\Spatie\MediaLibrary\MediaLibraryServiceProvider::class);
        $app->register(\Spatie\Permission\PermissionServiceProvider::class);
        $app->register(\Astrotomic\Translatable\TranslatableServiceProvider::class);
        $app->register(\Ignite\Foundation\LitstackServiceProvider::class);
    }

    /**
     * Get path to orchestra testbench-core.
     *
     * @return void
     */
    public function orchestraPath()
    {
        return $this->vendorPath().'/orchestra/testbench-core';
    }

    /**
     * Gets path to vendor directory.
     *
     * @return string|bool
     */
    public function vendorPath()
    {
        return realpath(__DIR__.'/../vendor/')
            ?: realpath(__DIR__.'/../../../');
    }
}
