<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    private static string $title;

    public function __construct()
    {
        self::$title = 'Dashboard';
    }
    public function index()
    {
        return view('dashboard.index', [
            'title' => self::$title,
        ]);
    }
}

