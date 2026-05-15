<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends SekolahAwareController
{
    public function index()
    {
        $siswa = Auth::guard('siswa')->user();
        
        return view('dashboard.siswa.index', compact('siswa'));
    }
}
