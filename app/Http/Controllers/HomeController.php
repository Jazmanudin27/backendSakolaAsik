<?php

namespace App\Http\Controllers;

class HomeController extends SekolahAwareController
{

    public function siswaDashboard()
    {
        return view('dashboard.siswa.index');
    }

    public function adminDashboard()
    {
        return view('dashboard.admin.index');
    }

    public function guruDashboard()
    {
        return view('dashboard.guru.index');
    }
}
