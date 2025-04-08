<?php

if (!function_exists('format_money')) {
    function format_money($amount) {
        return number_format($amount, 2);
    }
}

if (!function_exists('is_admin')) {
    function is_admin() {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }
}

if (!function_exists('is_employee')) {
    function is_employee() {
        return auth()->check() && auth()->user()->hasRole('Employee');
    }
}

if (!function_exists('is_customer')) {
    function is_customer() {
        return auth()->check() && auth()->user()->hasRole('Customer');
    }
}

if (!function_exists('isPrime')) {
    function isPrime($number)
    {
        if($number<=1) return false;
        $i = $number - 1;
        while($i>1) {
        if($number%$i==0) return false;
        $i--;
        }
        return true;
    }
}
