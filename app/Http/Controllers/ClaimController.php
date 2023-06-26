<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ClaimInterface;
use Illuminate\Support\Facades\Redis;

class ClaimController extends Controller
{
    private $claimInterface;
    public function __construct(ClaimInterface $claimInterface){
        $this->claimInterface = $claimInterface;
    }
    public function create(Request $request){
        return $this->claimInterface->create($request);
    }
}
