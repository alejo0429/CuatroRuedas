<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index($page = 1){
        //Owner::where('name', 'Alejandro');
        //$owners = Owner::where('name', 'Alejandro Barragan')->where('document', '123456')->get();
        $owners = DB::table('owners')->simplePaginate(15);
        return [
            'items' => $owners,
            'type' => 'Owner',
            'totalItems' => count($owners),
            'currentPage' => $page,
        ];
    }
    public function create(){
        Owner::create($this->validateRequest());
    }

    public function update(Owner $owner){
        $owner->update($this->validateRequest());
    }

    private function validateRequest(){
        return request()->validate([
            'plate' => ['required', 'unique:vehicles'],
            'brand' => ['required'],
            'model' => ['required'],
            'type' => ['required'],
            'owner_id' => ['required']
        ]);
    }
}
