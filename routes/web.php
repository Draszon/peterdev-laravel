<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
    Route::livewire('technology', 'pages::technology-admin')->name('admin.technology');
    Route::livewire('works', 'pages::works-admin')->name('admin.works');
    Route::livewire('messages', 'pages::messages-admin')->name('admin.messages');
    Route::livewire('contacts', 'pages::contacts-admin')->name('admin.contacts');
});

require __DIR__.'/settings.php';
