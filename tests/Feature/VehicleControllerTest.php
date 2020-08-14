<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use app\Vehicle;

class VehicleControllerTest extends TestCase
{
    /** @test */
    public function checkIfCreatesOwner()
    {
        $response = $this->post('/Vehicle/Store', [
            'plate' => 'ABC124',
            'brand' => 'Ferrari',
            'model' => 'F8 Tributo',
            'type'=>  'Carro',
            'owner_id' => ['required']
        ]);
        $response->assertOk();
        $this->assertCount(1, Vehicle::all());
    }

    /** @test */
    public function plateIsRequired()
    {
        $response = $this->post('/Vehicle/Store', [
            'plate' => '',
            'brand' => 'Ferrari',
            'model' => 'F8 Tributo',
            'type'=>  'Carro'
        ]);
        $response->assertSessionHasErrors('plate');
    }

    public function brandIsRequired()
    {
        $response = $this->post('/Vehicle/Store', [
            'plate' => 'ABC123',
            'brand' => '',
            'model' => 'F8 Tributo',
            'type'=>  'Carro'
        ]);
        $response->assertSessionHasErrors('brand');
    }

    public function modelIsRequired()
    {
        $response = $this->post('/Vehicle/Store', [
            'plate' => 'ABC123',
            'brand' => 'Ferrari',
            'model' => '',
            'type'=>  'Carro'
        ]);
        $response->assertSessionHasErrors('model');
    }

    public function typeIsRequired()
    {
        $response = $this->post('/Vehicle/Store', [
            'plate' => 'ABC123',
            'brand' => 'Ferrari',
            'model' => 'F8 Tributo',
            'type'=>  ''
        ]);
        $response->assertSessionHasErrors('type');
    }

    /** @test */
    public function checkIfUpdatesVehicle()
    {
        $this->post('/Vehicle/Store', [
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);
        $vehicle = Vehicle::first();

        $response = $this->patch("/Vehicle/Store/$vehicle->id", [
            'name' => 'Manuel Velasquez',
            'document' => '123456789'
        ]);
        $this->assertEquals('Manuel Velasquez', Vehicle::first()->name);
        $this->assertEquals('123456789', Vehicle::first()->document);
    }

    /** @test */
    public function plateIsUniqueCreating()
    {
        $this->post('/Vehicle/Store', [
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);

        $this->post("/Vehicle/Store", [
            'name' => 'Marcela Rojas',
            'document' => '123456789'
        ]);

        $response = $this->post("/Vehicle/Store", [
            'name' => 'Manuel Velasquez',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function plateIsUniqueUpdating()
    {
        $this->post('/Vehicle/Store', [
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);

        $vehicle = Vehicle::first();

        $this->post("/Vehicle/Store", [
            'name' => 'Marcela Rojas',
            'document' => '123456789'
        ]);

        $response = $this->patch("/Vehicle/Store/$vehicle->id", [
            'name' => 'Alejandro Barragan',
            'document' => '123456'
        ]);
        $response->assertSessionHasErrors();
    }
}
