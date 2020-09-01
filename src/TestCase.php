<?php

namespace Litstack\Rehearsal;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Get application providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    public function getApplicationProviders($app)
    {
        return array_merge(
            parent::getApplicationProviders($app),
            $this->getFjordProviders()
        );
    }

    /**
     * Get service providers required for the fjord package.
     *
     * @return array
     */
    protected function getFjordProviders()
    {
        return [
            \Cviebrock\EloquentSluggable\ServiceProvider::class,
            \Spatie\MediaLibrary\MediaLibraryServiceProvider::class,
            \Spatie\Permission\PermissionServiceProvider::class,
            \Astrotomic\Translatable\TranslatableServiceProvider::class,
            \Fjord\FjordServiceProvider::class,
        ];
    }
}
