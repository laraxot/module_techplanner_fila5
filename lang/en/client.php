<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'techplanner',
        'label' => 'Clients',
        'icon' => 'techplanner-client',
        'sort' => 30,
    ],
    'actions' => [
        'geocodeCoordinates' => [
            'label' => 'Update from address',
            'failed_title' => 'Geocoding failed',
            'success_title' => 'Coordinates updated from address',
        ],
        'create' => [
            'label' => 'New Client',
        ],
        'import' => [
            'label' => 'Import Clients',
        ],
        'importClient' => [
            'label' => 'Import Clients',
        ],
        'populateCoordinates' => [
            'label' => 'Update Coordinates',
            'modal' => ['heading' => 'Update Coordinates', 'description' => 'Update coordinates for all clients from their addresses?', 'submit_label' => 'Yes, update all'],
        ],
        'updateCoordinates' => [
            'label' => 'Update Coordinates',
        ],
        'sortByDistance' => [
            'label' => 'Sort by Distance',
        ],
        'downloadExample' => [
            'label' => 'Download Example',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'business_closed' => [
            'label' => 'Business Closed',
            'description' => 'business_closed',
            'helper_text' => 'business_closed',
            'placeholder' => 'business_closed',
        ],
        'company_name' => [
            'label' => 'Company Name',
            'description' => 'company_name',
            'helper_text' => 'company_name',
            'placeholder' => 'company_name',
        ],
        'latitude' => [
            'label' => 'Latitude',
            'description' => 'latitude',
            'helper_text' => 'latitude',
            'placeholder' => 'latitude',
        ],
        'longitude' => [
            'label' => 'Longitude',
            'description' => 'longitude',
            'helper_text' => 'longitude',
            'placeholder' => 'longitude',
        ],
        'distance' => [
            'label' => 'Distance',
        ],
        'distance_km' => [
            'label' => 'km',
        ],
        'last_rx_control_date' => [
            'label' => 'Last X-ray check',
        ],
        'last_intraoral_control_date' => [
            'label' => 'Last intraoral check',
        ],
        'last_electromedical_control_date' => [
            'label' => 'Last electromedical check',
        ],
        'last_health_authorization_date' => [
            'label' => 'Last health authorization',
        ],
        'is_active' => [
            'label' => 'Active',
        ],
        'full_address' => [
            'label' => 'Full Address',
        ],
        'country' => [
            'label' => 'Country',
            'description' => 'country',
            'helper_text' => 'country',
            'placeholder' => 'country',
        ],
        'tax_code' => [
            'label' => 'Tax Code',
            'description' => 'tax_code',
            'helper_text' => 'tax_code',
            'placeholder' => 'tax_code',
        ],
        'vat_number' => [
            'label' => 'VAT Number',
            'description' => 'vat_number',
            'helper_text' => 'vat_number',
            'placeholder' => 'vat_number',
        ],
        'fiscal_code' => [
            'label' => 'Fiscal Code',
            'description' => 'fiscal_code',
            'helper_text' => 'fiscal_code',
            'placeholder' => 'fiscal_code',
        ],
        'competent_health_unit' => [
            'label' => 'Competent Health Unit',
            'description' => 'competent_health_unit',
            'helper_text' => 'competent_health_unit',
            'placeholder' => 'competent_health_unit',
        ],
        'address' => [
            'label' => 'Address',
            'description' => 'address',
            'helper_text' => 'address',
            'placeholder' => 'address',
        ],
        'street_number' => [
            'label' => 'Street Number',
            'description' => 'street_number',
            'helper_text' => 'street_number',
            'placeholder' => 'street_number',
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'description' => 'postal_code',
            'helper_text' => 'postal_code',
            'placeholder' => 'postal_code',
        ],
        'province' => [
            'label' => 'Province',
            'description' => 'province',
            'helper_text' => 'province',
            'placeholder' => 'province',
        ],
        'phone' => [
            'label' => 'Phone',
        ],
        'fax' => [
            'label' => 'Fax',
        ],
        'mobile' => [
            'label' => 'Mobile',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'notes' => [
            'label' => 'Notes',
            'description' => 'notes',
            'helper_text' => 'notes',
            'placeholder' => 'notes',
        ],
        'activity' => [
            'label' => 'Activity',
            'description' => 'activity',
            'helper_text' => 'activity',
            'placeholder' => 'activity',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'city' => [
            'label' => 'City',
            'description' => 'city',
            'helper_text' => 'city',
            'placeholder' => 'city',
        ],
        'company_office' => [
            'label' => 'Company Office',
            'description' => 'company_office',
            'helper_text' => 'company_office',
            'placeholder' => 'company_office',
        ],
        'sortByDistance' => [
            'label' => 'Sort by Distance',
        ],
        'toggleColumns' => [
            'label' => 'Toggle Columns',
        ],
        'reorderRecords' => [
            'label' => 'Reorder Records',
        ],
        'resetFilters' => [
            'label' => 'Reset Filters',
        ],
        'applyFilters' => [
            'label' => 'Apply Filters',
        ],
        'openFilters' => [
            'label' => 'Open Filters',
        ],
        'value' => [
            'label' => 'Value',
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
        ],
        'delete' => [
            'label' => 'Delete',
        ],
        'edit' => [
            'label' => 'Edit',
        ],
        'values' => [
            'label' => 'Values',
            'description' => 'values',
            'helper_text' => 'values',
            'placeholder' => 'values',
        ],
        'view' => [
            'label' => 'View',
        ],
        'create' => [
            'label' => 'Create',
        ],
        'file' => [
            'label' => 'File',
        ],
        'distance_calc' => [
            'label' => 'distance_calc',
        ],
        'contacts' => [
            'label' => 'contacts',
            'description' => 'contacts',
            'helper_text' => 'contacts',
            'placeholder' => 'contacts',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'street_address' => [
            'description' => 'street_address',
            'helper_text' => 'street_address',
            'placeholder' => 'street_address',
            'label' => 'street_address',
        ],
        'created_at' => [
            'description' => 'created_at',
            'helper_text' => 'created_at',
            'placeholder' => 'created_at',
            'label' => 'created_at',
        ],
        'updated_at' => [
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
            'placeholder' => 'updated_at',
            'label' => 'updated_at',
        ],
    ],
    'import' => [
        'label' => 'Import Clients',
        'name' => [
            'label' => 'Name',
        ],
        'vat_number' => [
            'label' => 'VAT Number',
        ],
        'fiscal_code' => [
            'label' => 'Fiscal Code',
        ],
        'city' => [
            'label' => 'City',
        ],
        'province' => [
            'label' => 'Province',
        ],
        'phone' => [
            'label' => 'Phone',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'is_active' => [
            'label' => 'Active',
        ],
        'created_at' => [
            'label' => 'Creation Date',
        ],
        'updated_at' => [
            'label' => 'Update Date',
        ],
        'view' => [
            'label' => 'View',
        ],
        'edit' => [
            'label' => 'Edit',
        ],
        'activity' => [
            'label' => 'Activity',
        ],
    ],
    'filters' => [
        'has_controls' => ['label' => 'Has recorded controls'],
        'controls_expiring' => ['label' => 'Controls expiring (30 days)'],
        'never_controlled_type' => ['label' => 'Never controlled by type'],
        'has_rx_control' => ['label' => 'RX control'],
        'has_electromedical_control' => ['label' => 'Electromedical control'],
        'has_health_authorization' => ['label' => 'Health authorization'],
    ],
    'map' => [
        'markers_shown' => 'Showing :count client markers with coordinates',
        'aria_label' => 'Client map',
        'set_origin' => 'Use as origin',
        'set_origin_tooltip' => 'Sort all clients by distance from this point',
        'origin_popup' => 'Distance reference point',
        'origin_set' => ['title' => 'Origin point set', 'body' => 'The table has been sorted by distance from this client.'],
        'origin_missing' => ['title' => 'Missing coordinates', 'body' => 'The selected client has no usable coordinates.'],
        'origin_missing_geocode_failed' => [
            'title' => 'Geocoding failed',
            'body' => 'Could not geocode the client address. Check the address or use "Update Coordinates" to populate all missing coordinates.',
        ],
    ],
    'location_map' => [
        'heading' => 'Client location',
        'aria_label' => 'Client location map',
        'google_maps' => 'Open in Google Maps',
        'viamichelin' => 'Open in ViaMichelin',
        'missing' => 'Coordinates are not available. Complete the address and use “Update from address” in the Coordinates section.',
    ],
    'messages' => [
        'coordinates_batch_summary' => 'Processed :processed clients. Successfully updated :success coordinates.',
        'coordinates_batch_warning' => 'Coordinate update completed with errors',
        'coordinates_batch_success' => 'Coordinates updated successfully',
        'coordinates_updated' => 'Coordinates updated successfully',
        'coordinates_update_failed' => 'Coordinate update failed',
        'import_success' => 'Import completed successfully',
        'import_failed' => 'Import failed',
    ],
    'model' => [
        'label' => 'Client',
        'plural' => 'Clients',
    ],
    'sections' => [
        'coordinates' => [
            'label' => 'Coordinates',
            'description' => 'Client latitude and longitude. Save the address first, then update coordinates here for distance and map.',
        ],
        'contacts' => [
            'heading' => 'Contacts',
            'label' => 'Contacts',
        ],
        'address_info' => [
            'label' => 'Address',
        ],
        'address' => [
            'heading' => 'address',
            'label' => 'address',
        ],
    ],
];
