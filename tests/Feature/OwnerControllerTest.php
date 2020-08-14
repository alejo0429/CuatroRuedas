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
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);
        $response->assertOk();
        $this->assertCount(1, Owner::all());
    }

    /** @test */
    public function documentIsRequired()
    {
        $response = $this->post('/Owner/Store', [
            'name' => 'Alejandro Barragan',
            'document' => ''
        ]);
        $response->assertSessionHasErrors('document');
    }

    /** @test */
    public function nameIsRequired()
    {
        $response = $this->post('/Owner/Store', [
            'name' => '',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function checkIfUpdatesOwner()
    {
        $this->post('/Owner/Store', [
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);
        $owner = Owner::first();

        $response = $this->patch("/Owner/Store/$owner->id", [
            'name' => 'Manuel Velasquez',
            'document' => '123456789'
        ]);
        $this->assertEquals('Manuel Velasquez', Owner::first()->name);
        $this->assertEquals('123456789', Owner::first()->document);
    }

    /** @test */
    public function documentIsUniqueCreating()
    {
        $this->post('/Owner/Store', [
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);

        $this->post("/Owner/Store", [
            'name' => 'Marcela Rojas',
            'document' => '123456789'
        ]);

        $response = $this->post("/Owner/Store", [
            'name' => 'Manuel Velasquez',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function documentIsUniqueUpdating()
    {
        $this->post('/Owner/Store', [
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);

        $owner = Owner::first();

        $this->post("/Owner/Store", [
            'name' => 'Marcela Rojas',
            'document' => '123456789'
        ]);

        $response = $this->patch("/Owner/Store/$owner->id", [
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors();
    }
}
