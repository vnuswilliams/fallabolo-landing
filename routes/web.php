<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

Route::view('/', 'welcome')->name('home');

Route::get('/legal/{slug}', function (string $slug) {
    $path = base_path($slug . '.md');

    if (!File::exists($path)) {
        abort(404);
    }

    $content = File::get($path);
    $html = Str::markdown($content);
    $title = strtoupper($slug);

    return view('legal', [
        'content' => $html,
        'title' => $title,
    ]);
})->name('legal.show');
