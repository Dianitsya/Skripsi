<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KumpulanModul;


class KumpulanModulController extends Controller
{
    public function index()
    {
        $modules = KumpulanModul::all();
        return view('module.kumpulanmodul', compact('modules'));
    }
}
