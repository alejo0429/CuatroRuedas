<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OwnerControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        //$response = $this->call('GET', 'user/profile');
        $response = $this->call('GET', 'Owner', $parameters, $cookies, $files, $server, $content);
        
        $response->assertStatus(200);
    }
}
