<?php

declare(strict_types=1);

?>
@php
    $mapId = 'client-map-'.\Illuminate\Support\Str::random(8);
@endphp

<div
    class="client-map-widget"
    data-map-id="{{ $mapId }}"
    wire:ignore
>
    <link rel="stylesheet" href="{{ $asset_base }}/leaflet.css">
    <style>
        .client-map-marker-dot {
            display: block;
            width: 14px;
            height: 14px;
            border-radius: 9999px;
            background: #2563eb;
            border: 2px solid #fff;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
        }
        .client-map-origin-dot {
            display: block;
            width: 18px;
            height: 18px;
            border-radius: 9999px;
            background: #dc2626;
            border: 3px solid #fff;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.5);
        }
    </style>
    <div
        id="{{ $mapId }}"
        role="region"
        aria-label="{{ __('techplanner::client.map.aria_label') }}"
        tabindex="0"
        style="height: 420px; width: 100%; border-radius: 0.5rem;"
    ></div>
    <div class="text-xs text-gray-500 mt-2">
        {{ trans('techplanner::client.map.markers_shown', ['count' => count($markers)]) }}
    </div>
</div>

@script
<script>
    (() => {
        const mapId = @js($mapId);
        const markers = @js($markers);
        const origin = @js($origin);
        const assetBase = @js($asset_base);
        const state = window.TechPlannerClientMaps ??= {};

        state.escape ??= (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
        state.setOrigin = (clientId) => $wire.setDistanceOrigin(clientId);

        const initialize = () => {
            const element = document.getElementById(mapId);
            if (!element || typeof window.L === 'undefined') {
                return false;
            }
            if (element.dataset.clientMapReady === '1') {
                state.maps?.[mapId]?.invalidateSize();
                return true;
            }

            const map = window.L.map(element, { scrollWheelZoom: false });
            state.maps ??= {};
            state.maps[mapId] = map;
            element.dataset.clientMapReady = '1';
            window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(map);

            const bounds = [];
            markers.filter((marker) => marker.latitude !== null && marker.longitude !== null
                && Number.isFinite(Number(marker.latitude)) && Number.isFinite(Number(marker.longitude)))
                .forEach((marker) => {
                    const latitude = Number(marker.latitude);
                    const longitude = Number(marker.longitude);
                    const icon = window.L.divIcon({
                        className: 'client-map-marker',
                        html: '<span class="client-map-marker-dot"></span>',
                        iconSize: [14, 14],
                        iconAnchor: [7, 7],
                    });
                    const clientMarker = window.L.marker([latitude, longitude], { icon }).addTo(map);
                    bounds.push([latitude, longitude]);
                    const markerEl = clientMarker.getElement();
                    if (markerEl) {
                        markerEl.setAttribute('tabindex', '0');
                        markerEl.setAttribute('role', 'button');
                        markerEl.setAttribute('aria-label', marker.label);
                        markerEl.addEventListener('keydown', (event) => {
                            if (event.key === 'Enter' || event.key === ' ') {
                                event.preventDefault();
                                clientMarker.openPopup();
                            }
                        });
                    }
                    const rows = [
                        marker.address ? `<div>${state.escape(marker.address)}</div>` : '',
                        marker.phone ? `<div><a href="tel:${state.escape(marker.phone)}">${state.escape(marker.phone)}</a></div>` : '',
                    ].join('');
                    clientMarker.bindPopup(`
                        <div class="client-map-popup" style="min-width: 200px;">
                            <strong>${state.escape(marker.label)}</strong>${rows}
                            <div style="margin-top: 6px; display: flex; gap: 6px; flex-wrap: wrap;">
                                <a class="fi-btn fi-btn-color-gray fi-btn-size-sm" href="${state.escape(marker.view_url)}">{{ trans('filament-actions::modal.view.actions.view.label') }}</a>
                                <a class="fi-btn fi-btn-color-gray fi-btn-size-sm" href="${state.escape(marker.edit_url)}">{{ trans('filament-actions::modal.edit.actions.edit.label') }}</a>
                                <button type="button" class="fi-btn fi-btn-color-primary fi-btn-size-sm" onclick="window.TechPlannerClientMaps.setOrigin(${Number(marker.id)})">{{ trans('techplanner::client.map.set_origin') }}</button>
                            </div>
                        </div>
                    `);
                });

            if (Number.isFinite(Number(origin.latitude)) && Number.isFinite(Number(origin.longitude))) {
                const latitude = Number(origin.latitude);
                const longitude = Number(origin.longitude);
                window.L.marker([latitude, longitude], {
                    icon: window.L.divIcon({
                        className: 'client-map-origin-marker',
                        html: '<span class="client-map-origin-dot"></span>',
                        iconSize: [18, 18],
                        iconAnchor: [9, 9],
                    }),
                }).addTo(map).bindPopup({ content: @js(trans('techplanner::client.map.origin_popup')) });
                bounds.push([latitude, longitude]);
            }

            if (bounds.length === 1) {
                map.setView(bounds[0], 14);
            } else if (bounds.length > 1) {
                map.fitBounds(bounds, { padding: [30, 30], maxZoom: 13 });
            } else {
                map.setView([41.8719, 12.5674], 6);
            }

            [0, 150, 500].forEach((delay) => window.setTimeout(() => map.invalidateSize(), delay));
            if (window.ResizeObserver) {
                new ResizeObserver(() => map.invalidateSize()).observe(element);
            }
            return true;
        };

        const leafletScript = document.querySelector('script[data-client-map-leaflet]');
        if (typeof window.L !== 'undefined') {
            initialize();
        } else if (leafletScript) {
            leafletScript.addEventListener('load', initialize, { once: true });
        } else {
            const script = document.createElement('script');
            script.src = `${assetBase}/leaflet.js`;
            script.dataset.clientMapLeaflet = '1';
            script.onload = initialize;
            document.head.appendChild(script);
        }
    })();
</script>
@endscript
