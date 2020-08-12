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
        $response = $this->post('/Owner/Store', [
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
        $response = $this->post('/Owner/Store', [
            'first_name' => 'Alejandro',
            'last_name' => 'Barragan',
            'document' => ''
        ]);
        $response->assertSessionHasErrors('document');
    }

    /** @test */
    public function firstNameIsRequired()
    {
        $response = $this->post('/Owner/Store', [
            'first_name' => '',
            'last_name' => 'Barragan',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors('first_name');
    }

    /** @test */
    public function lastNameIsRequired()
    {
        $response = $this->post('/Owner/Store', [
            'first_name' => 'Alejandro',
            'last_name' => '',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors('last_name');
    }

    /** @test */
    public function checkIfUpdatesOwner()
    {
        $this->post('/Owner/Store', [
            'first_name' => 'Alejandro',
            'last_name' => 'Barragan',
            'document' => '123456'
        ]);
        $owner = Owner::first();

        $response = $this->patch("/Owner/Store/$owner->id", [
            'first_name' => 'Manuel',
            'last_name' => 'Velasquez',
            'document' => '123456789'
        ]);
        $this->assertEquals('Manuel', Owner::first()->first_name);
        $this->assertEquals('Velasquez', Owner::first()->last_name);
        $this->assertEquals('123456789', Owner::first()->document);
    }

    /** @test */
    public function checksUniqueDocumentCreating()
    {
        $this->post('/Owner/Store', [
            'first_name' => 'Alejandro',
            'last_name' => 'Barragan',
            'document' => '123456'
        ]);

        $this->post("/Owner/Store", [
            'first_name' => 'Marcela',
            'last_name' => 'Rojas',
            'document' => '123456789'
        ]);

        $response = $this->post("/Owner/Store", [
            'first_name' => 'Manuel',
            'last_name' => 'Velasquez',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function checksUniqueDocumentUpdating()
    {
        $this->post('/Owner/Store', [
            'first_name' => 'Alejandro',
            'last_name' => 'Barragan',
            'document' => '123456'
        ]);

        $owner = Owner::first();

        $this->post("/Owner/Store", [
            'first_name' => 'Marcela',
            'last_name' => 'Rojas',
            'document' => '123456789'
        ]);

        $response = $this->patch("/Owner/Store/$owner->id", [
            'first_name' => 'Alejandro',
            'last_name' => 'Barragan',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors();
    }
}
