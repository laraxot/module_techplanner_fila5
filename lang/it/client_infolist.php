<?php

declare(strict_types=1);

return [
    'sections' => [
        'tech_planner::client' => [
            'sections' => [
                'company' => [
                    'label' => ['label' => 'tech_planner::client.sections.company.label', 'heading' => 'tech_planner::client.sections.company.label'],
                ],
                'contact_info' => [
                    'label' => ['label' => 'tech_planner::client.sections.contact_info.label', 'heading' => 'tech_planner::client.sections.contact_info.label'],
                ],
                'additional_info' => [
                    'label' => ['label' => 'tech_planner::client.sections.additional_info.label', 'heading' => 'tech_planner::client.sections.additional_info.label'],
                ],
            ],
        ],
    ],
    'fields' => [
        'company_name' => ['label' => 'company_name'],
        'activity' => ['label' => 'activity'],
        'business_closed' => ['label' => 'business_closed'],
        'tax_code' => ['label' => 'tax_code'],
        'vat_number' => ['label' => 'vat_number'],
        'fiscal_code' => ['label' => 'fiscal_code'],
        'address' => ['label' => 'address'],
        'street_number' => ['label' => 'street_number'],
        'city' => ['label' => 'city'],
        'postal_code' => ['label' => 'postal_code'],
        'province' => ['label' => 'province'],
        'country' => ['label' => 'country'],
        'phone' => ['label' => 'phone'],
        'mobile' => ['label' => 'mobile'],
        'fax' => ['label' => 'fax'],
        'email' => ['label' => 'email'],
        'competent_health_unit' => ['label' => 'competent_health_unit'],
        'company_office' => ['label' => 'company_office'],
        'notes' => ['label' => 'notes'],
    ],
];
