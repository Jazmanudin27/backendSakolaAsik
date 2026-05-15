<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function loadMenu($menu)
    {
        $viewMap = [
            // Admin & Guru menus
            'data-master' => 'layouts.menus.data-master',
            'pendidikan' => 'layouts.menus.pendidikan',
            'laporan' => 'layouts.menus.laporan',
            'pengaturan' => 'layouts.menus.pengaturan',
            // Siswa menus
            'data-siswa' => 'layouts.menus.data-siswa',
            'ujian' => 'layouts.menus.ujian',
            'pengaturan-siswa' => 'layouts.menus.pengaturan-siswa',
        ];

        if (isset($viewMap[$menu])) {
            return view($viewMap[$menu]);
        }

        return response('Menu not found', 404);
    }
}
