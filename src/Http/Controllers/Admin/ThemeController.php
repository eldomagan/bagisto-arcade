<?php

namespace EldoMagan\BagistoArcade\Http\Controllers\Admin;

use EldoMagan\BagistoArcade\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = collect(config('themes.themes'))->filter(function ($theme) {
            return $theme['arcade_theme'] ?? false === true;
        });

        return view('arcade::admin.themes.index', ['themes' => $themes]);
    }
}
