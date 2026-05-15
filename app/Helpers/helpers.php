<?php

use App\Helpers\UserRoleHelper;

if (!function_exists('userRole')) {
    /**
     * Get the current user role (admin or guru)
     *
     * @return string
     */
    function userRole()
    {
        return UserRoleHelper::getCurrentUserRole();
    }
}

if (!function_exists('isAdmin')) {
    /**
     * Check if current user is admin
     *
     * @return bool
     */
    function isAdmin()
    {
        return UserRoleHelper::isAdmin();
    }
}

if (!function_exists('isGuru')) {
    /**
     * Check if current user is guru
     *
     * @return bool
     */
    function isGuru()
    {
        return UserRoleHelper::isGuru();
    }
}
