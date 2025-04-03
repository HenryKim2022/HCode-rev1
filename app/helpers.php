<?php
// HERES CUSTOM HELPERS

if (!function_exists('getAccountsByRole')) {
    function getAccountsByRole($role)
    {
        return \App\Models\AccountsModel::where('role', $role)->get();
    }
}

if (!function_exists('getAccountByEmail')) {
    function getAccountByEmail($email)
    {
        return \App\Models\AccountsModel::where('email', $email)->first();
    }
}
