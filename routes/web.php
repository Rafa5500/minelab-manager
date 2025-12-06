<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard; // Vamos criar esse componente agora

Route::get('/', function () {
    return view('dashboard');
});
