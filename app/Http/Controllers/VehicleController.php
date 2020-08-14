<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Vehicle;

class VehicleController extends Controller
{
    public function index(){
        Vehicle::all();
    }
    public function create(){
        Vehicle::create($this->validateRequest());
    }

    public function update(Vehicle $vehicle){
        $vehicle->update($this->validateRequest());
    }

    private function validateRequest(){
        return request()->validate([
            'name' => ['required'],
            'document' => ['required', 'unique:vehicles']
        ]);
    }
}
