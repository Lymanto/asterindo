<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDeleteData extends Controller
{
    public function index(Request $request)
    {
        if($request->session()->get('role_id') == '1'){
            return 'test';
        }else{
            return abort(403);
        }
    }
}
