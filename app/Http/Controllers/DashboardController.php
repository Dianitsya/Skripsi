<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;

class DashboardController extends Controller {
    public function index()
    {
        $modules = Module::with('category')->get();
        return view('dashboard', compact('modules'));
    }
}
