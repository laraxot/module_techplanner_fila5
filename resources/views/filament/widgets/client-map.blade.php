<?php

declare(strict_types=1);

?>
@php
    use Modules\TechPlanner\Models\Client;
@endphp

<div class="p-4 bg-white rounded-lg shadow">
    <div id="client-map" style="height: 400px;"></div>
</div>

@push('scripts')
<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById('client-map'), {
            zoom: 8,
            center: {lat: 41.8719, lng: 12.5674} // Default to Italy
        });

        @foreach($clients as $client)
            @if($client['latitude'] && $client['longitude'])
                new google.maps.Marker({
                    position: {lat: {{ $client['latitude'] }}, lng: {{ $client['longitude'] }}},
                    map: map,
                    title: '{{ $client['name'] }}'
                });
            @endif
        @endforeach
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap">
</script>
@endpush
