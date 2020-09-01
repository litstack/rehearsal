<?php

use Ignite\Support\Facades\Lit;
use Litstack\Rehearsal\TestCase;

class InstallationTest extends TestCase
{
    /** @test */
    public function test_litstack_is_installed()
    {
        $this->assertTrue(Lit::installed());
    }
}
