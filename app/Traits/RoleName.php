<?php

namespace App\Traits;

trait RoleName
{

    public static function getRoleName($id)
    {
        if ($id === 1) {
            return __('roles.1');
        } elseif ($id === 2) {
            return __('roles.2');
        } elseif ($id === 3) {
            return __('roles.3');
        } elseif ($id === 4) {
            return __('roles.4');
        }
    }
}
