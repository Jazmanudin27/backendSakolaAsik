<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class UserRoleHelper
{
    /**
     * Get the current user role (admin or guru)
     *
     * @return string
     */
    public static function getCurrentUserRole()
    {
        if (Auth::guard('guru')->check()) {
            return 'guru';
        }
        
        return 'admin';
    }
    
    /**
     * Check if current user is admin
     *
     * @return bool
     */
    public static function isAdmin()
    {
        return Auth::guard('admin')->check();
    }
    
    /**
     * Check if current user is guru
     *
     * @return bool
     */
    public static function isGuru()
    {
        return Auth::guard('guru')->check();
    }
}
