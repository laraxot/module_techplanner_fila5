<?php

declare(strict_types=1);

?>
@extends('techplanner::layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    <header class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $title ?? 'TechPlanner' }}</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $description ?? __('techplanner::home.sections.subtitle.description') }}</p>
    </header>

    <div class="grid md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl mb-4">🚀</div>
            <h3 class="text-xl font-semibold mb-2">{{ __('techplanner::home.cards.projects.title') }}</h3>
            <p class="text-gray-600 mb-4">{{ __('techplanner::home.cards.projects.description') }}</p>
            <a href="{{ route('techplanner.projects') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                {{ __('techplanner::home.cards.projects.cta') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl mb-4">👥</div>
            <h3 class="text-xl font-semibold mb-2">{{ __('techplanner::home.cards.contacts.title') }}</h3>
            <p class="text-gray-600 mb-4">{{ __('techplanner::home.cards.contacts.description') }}</p>
            <a href="{{ route('techplanner.contacts') }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                {{ __('techplanner::home.cards.contacts.cta') }}
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="text-3xl mb-4">📊</div>
            <h3 class="text-xl font-semibold mb-2">{{ __('techplanner::home.cards.dashboard.title') }}</h3>
            <p class="text-gray-600 mb-4">{{ __('techplanner::home.cards.dashboard.description') }}</p>
            <a href="{{ route('techplanner.dashboard') }}" class="inline-block bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition">
                {{ __('techplanner::home.cards.dashboard.cta') }}
            </a>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('techplanner::home.sections.welcome.title') }}</h2>
        <p class="text-gray-600 mb-6">
            {{ __('techplanner::home.sections.welcome.description') }}
        </p>
        <div class="space-x-4">
            <a href="{{ route('techplanner.projects') }}" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                {{ __('techplanner::home.welcome.create_project.label') }}
            </a>
            <a href="{{ route('techplanner.dashboard') }}" class="inline-block bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition">
                {{ __('techplanner::home.welcome.explore_dashboard.label') }}
            </a>
        </div>
    </div>
</div>

<style>
/* CSS temporaneo finché non è configurato Vite */
.container { max-width: 1200px; }
.mx-auto { margin-left: auto; margin-right: auto; }
.px-4 { padding-left: 1rem; padding-right: 1rem; }
.py-8 { padding-top: 2rem; padding-bottom: 2rem; }
.text-center { text-align: center; }
.mb-12 { margin-bottom: 3rem; }
.mb-4 { margin-bottom: 1rem; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-6 { margin-bottom: 1.5rem; }
.text-4xl { font-size: 2.25rem; }
.text-xl { font-size: 1.25rem; }
.text-2xl { font-size: 1.5rem; }
.text-3xl { font-size: 1.875rem; }
.font-bold { font-weight: 700; }
.font-semibold { font-weight: 600; }
.text-gray-800 { color: #1f2937; }
.text-gray-600 { color: #4b5563; }
.max-w-2xl { max-width: 42rem; }
.grid { display: grid; }
.gap-8 { gap: 2rem; }
.bg-white { background-color: white; }
.bg-gray-50 { background-color: #f9fafb; }
.rounded-lg { border-radius: 0.5rem; }
.shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
.p-6 { padding: 1.5rem; }
.p-8 { padding: 2rem; }
.inline-block { display: inline-block; }
.bg-blue-500 { background-color: #3b82f6; }
.bg-green-500 { background-color: #10b981; }
.bg-purple-500 { background-color: #8b5cf6; }
.bg-gray-500 { background-color: #6b7280; }
.text-white { color: white; }
.px-4 { padding-left: 1rem; padding-right: 1rem; }
.px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
.py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
.py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
.rounded { border-radius: 0.25rem; }
.space-x-4 > * + * { margin-left: 1rem; }
.transition { transition-property: all; transition-duration: 150ms; }

@media (min-width: 768px) {
    .md\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}
</style>
@endsection
