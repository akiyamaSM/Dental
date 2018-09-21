<?php

use App\Mailer\Houssin;

class FooTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @test
     */
    public function it_creates_mockery()
    {
        $mocked = Mockery::mock(Houssin::class);
    }
}
