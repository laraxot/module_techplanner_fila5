<?php

declare(strict_types=1);

?>
<x-filament::widget>
    <x-filament::card>
        <div class="flex flex-col gap-y-4">
            <h2 class="text-lg font-medium">{{ __('techplanner::coordinates_widget.sections.title.title') }}</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <x-filament::input.wrapper>
                    <x-filament::input 
                        type="number" 
                        wire:model="latitude" 
                        step="0.000001"
                        placeholder="{{ __('techplanner::client.fields.latitude.label') }}"
                    />
                </x-filament::input.wrapper>

                <x-filament::input.wrapper>
                    <x-filament::input 
                        type="number" 
                        wire:model="longitude" 
                        step="0.000001"
                        placeholder="{{ __('techplanner::client.fields.longitude.label') }}"
                    />
                </x-filament::input.wrapper>
            </div>

            <x-filament::button
                wire:click="updateCoordinates"
                class="w-full"
            >
                {{ __('techplanner::coordinates_widget.actions.update_button.label') }}
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament::widget>
