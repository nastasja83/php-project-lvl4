<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    /**
     * Test of welcome page accessibility.
     *
     * @return void
     */
    public function testWelcome():void
    {
        $response = $this->get(route('welcome'));

        $response->assertOk();
        $response->assertSee('Привет от Хекслета!');
    }
}
