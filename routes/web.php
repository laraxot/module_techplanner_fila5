<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\TechPlanner\Actions\Contact\SubmitContactFormAction;

// TechPlanner specific routes
// Frontend pages are handled by Laravel Folio + Volt

// Form di contatto del sito: la vista (blocco `contact.form` del tema) usa route('techplanner.contact.submit').
// Gruppo `web` (sessione, CSRF) + throttle per IP: 5 invii ogni 10 minuti.
Route::post('/{lang}/contact', [SubmitContactFormAction::class, '__invoke'])
    ->where('lang', '[a-z]{2}')
    ->middleware('throttle:5,10')
    ->name('techplanner.contact.submit');
