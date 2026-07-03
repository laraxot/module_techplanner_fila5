<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Law Firm',
        'group' => 'TechPlanner',
        'icon' => 'heroicon-o-building-office',
        'sort' => 9,
    ],
    'resource' => [
        'label' => 'Law Firm',
        'plural_label' => 'Law Firms',
        'navigation_group' => 'TechPlanner',
        'navigation_icon' => 'heroicon-o-building-office',
        'navigation_sort' => 9,
        'description' => 'Law firm management',
    ],
    'actions' => [
        'create' => [
            'label' => 'New Law Firm',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Create a new law firm',
        ],
        'edit' => [
            'label' => 'Edit',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Edit law firm',
        ],
        'delete' => [
            'label' => 'Delete',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Delete law firm',
        ],
        'view' => [
            'label' => 'View',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'View law firm',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Firm Name',
            'placeholder' => 'Enter law firm name',
            'help' => 'Full name of the law firm',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter complete address',
            'help' => 'Complete address of the law firm',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter phone number',
            'help' => 'Main phone number',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter email address',
            'help' => 'Main email address of the firm',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'Enter website URL',
            'help' => 'Firm website URL',
        ],
        'vat_number' => [
            'label' => 'VAT Number',
            'placeholder' => 'Enter VAT number',
            'help' => 'Law firm VAT number',
        ],
        'fiscal_code' => [
            'label' => 'Fiscal Code',
            'placeholder' => 'Enter fiscal code',
            'help' => 'Law firm fiscal code',
        ],
        'is_active' => [
            'label' => 'Active',
            'help' => 'Whether the law firm is active',
        ],
    ],
    'filters' => [
        'is_active' => [
            'label' => 'Status',
            'options' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Select a city',
        ],
    ],
    'messages' => [
        'created' => 'Law firm created successfully',
        'updated' => 'Law firm updated successfully',
        'deleted' => 'Law firm deleted successfully',
        'not_found' => 'Law firm not found',
        'validation_error' => 'Validation error in entered data',
    ],
];
