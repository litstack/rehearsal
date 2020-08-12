<?php

use Fjord\Support\Facades\Fjord;
use Fjuse\Testbench\TestCase;

class InstallationTest extends TestCase
{
    /** @test */
    public function test_fjord_is_installed()
    {
        $this->assertTrue(Fjord::installed());
    }
}
