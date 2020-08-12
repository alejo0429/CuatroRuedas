<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;

class OwnerController extends Controller
{
    public function create(){
        Owner::create($this->validateRequest());
    }

    public function update(Owner $owner){
        $owner->update($this->validateRequest());
    }

    private function validateRequest(){
        return request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'document' => ['required', 'unique:owners']
        ]);
    }
}
