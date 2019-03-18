<?php

namespace App\Helpers;

use Auth;
use Session;
use App\Models\Training\{Course};

/**
 *
 */
class Helper
{
    public static function slug($key)
    {
        $user = Auth::user();
        return (string)$user->id.'-'.$key;
    }

    public static function has($key)
    {
        $slug = self::slug($key);
        return Session::exists($slug);
    }

    public static function get($key)
    {
        $slug = self::slug($key);
        return Session::get($slug);
    }

    public static function set($key, $value)
    {
        $slug = self::slug($key);
        return Session::put($slug, $value);
    }

    public static function drop($key)
    {
        $slug = self::slug($key);
        return Session::forget($slug);
    }

    public static function courses()
    {
        $key = 'courses';

        if(self::has($key)) {
            return self::get($key);
        }

        $courses = Course::all();

        self::set($key, $courses);
        return self::get($key);
    }
}
