<?php

namespace App\Http\Controllers;

use App\Model\Panel\Address;
use App\Model\Panel\DataSource;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
    	$address = new DataSource();
    	$data = $address->all();
    	dd($data);
    }
}
