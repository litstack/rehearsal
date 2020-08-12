<?php

namespace Fjuse\Testbench;

use Fjord\Fjord\Discover\PackageDiscoverCommand;
use Fjord\Support\Facades\Fjord;
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

        if (Fjord::installed()) {
            return false;
        }

        try {
            $this->artisan('fjord:install');
        } catch (Throwable $e) {
            return false;
        }

        try {
            $this->discoverFjordPackages();
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
        $app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);
        $app->register(\Spatie\MediaLibrary\MediaLibraryServiceProvider::class);
        $app->register(\Spatie\Permission\PermissionServiceProvider::class);
        $app->register(\Astrotomic\Translatable\TranslatableServiceProvider::class);
        $app->register(\Fjord\FjordServiceProvider::class);
    }

    /**
     * Discover fjord packages and write manifest.
     *
     * @return void
     */
    protected function discoverFjordPackages()
    {
        $finder = new PackageDiscoverCommand();

        $vendorPath = realpath(__DIR__.'/../../../');

        $finder->write(
            $finder->findFjordPackages($vendorPath)
        );
    }

    /**
     * Get path to orchestra testbench-core.
     *
     * @return void
     */
    public function orchestraPath()
    {
        return __DIR__.'/../../../orchestra/testbench-core';
    }
}
