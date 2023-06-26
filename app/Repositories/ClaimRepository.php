<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use App\Interfaces\ClaimInterface;
use App\Models\Claim;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class ClaimRepository implements ClaimInterface
{
    public function create($request)
    {

        return $request->all();
    }
}
