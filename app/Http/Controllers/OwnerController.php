<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;

class OwnerController extends Controller
{
    public function create(){
        $data = request()->validate([
            'document' => 'required'
        ]);
        Owner::create($data);
    }
}
