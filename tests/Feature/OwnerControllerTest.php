<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Owner;

class OwnerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function checkIfCreatesOwner()
    {
        $response = $this->post('/Owner/Create', [
            'first_name' => 'Alejandro',
            'last_name' => 'Barragan',
            'document' => '123456'
        ]);
        $response->assertOk();
        $this->assertCount(1, Owner::all());
    }

    /** @test */
    public function documentIsRequired()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/Owner/Create', [
            'first_name' => 'Alejandro',
            'last_name' => 'Barragan',
            'document' => ''
        ]);
        $response->assertSessionHasErrors('cedula');
    }
}
