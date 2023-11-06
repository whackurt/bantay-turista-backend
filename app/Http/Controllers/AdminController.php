<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function allAdmin(){
        $admins = Admin::all();
        return view('admin.index', ['admins' => $admins]);
    }
    
    public function singleAdmin($id){
        $admin = Admin::find($id);
        return view('admin.admin', ['admin' => $admin]);
    }
}
