<?php

namespace Litstack\Rehearsal;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class InstallerPlugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * Composer instance.
     *
     * @var Composer
     */
    protected $composer;

    /**
     * IO instance.
     *
     * @var IOInterface
     */
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        //
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        //
    }

    /**
     * Get subsribed events.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'post-autoload-dump' => [
                ['onPostAutoloadDump', 0],
            ],
        ];
    }

    /**
     * Handle post-autoload-dump event.
     *
     * @return void
     */
    public function onPostAutoloadDump()
    {
        exec('php '.realpath(__DIR__.'/../bin').'/install', $output);

        if (empty($output)) {
            return;
        }

        if ($output[0] == true) {
            $this->io->write('Installed fjord to testbench.');
        }
    }
}
