<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Hash;

use App\Interfaces\DemoInterface;
use App\Models\Demo;

class DemoRepository implements DemoInterface
{
    public function create($request){
        return Demo::create([
            'name' => $request->name,
            'company' => $request->company,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
            'email' => $request->email
        ]);
    }
}