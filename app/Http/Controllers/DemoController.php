<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\DemoInterface;
use Illuminate\Support\Facades\Redis;

class DemoController extends Controller
{
    private $demoInterface;
    public function __construct(DemoInterface $demoInterface){
        $this->demoInterface = $demoInterface;
    }
    public function create(Request $request){
        return $this->demoInterface->create($request);
    }
}
