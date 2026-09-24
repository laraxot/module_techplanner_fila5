<?php

declare(strict_types=1);

return [
    // ==============================================
    // NAVIGATION & STRUCTURE
    // ==============================================
    'navigation' => [
        'label' => 'Appointments',
        'plural_label' => 'Appointments',
        'group' => 'TechPlanner',
        'icon' => 'heroicon-o-calendar-days',
        'sort' => 10,
        'badge' => 'Appointment management',
    ],
    // ==============================================
    // MODEL INFORMATION
    // ==============================================
    'model' => [
        'label' => 'Appointment',
        'plural' => 'Appointments',
        'description' => 'Appointment and booking management',
    ],
    // ==============================================
    // FIELDS - STRUTTURA ESPANSA OBBLIGATORIA
    // ==============================================
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique appointment identifier',
            'helper_text' => 'Unique numeric identifier of the appointment in the system',
        ],
        'client_id' => [
            'label' => 'Client',
            'placeholder' => 'Select client',
            'tooltip' => 'Client for whom the appointment is scheduled',
            'helper_text' => 'Specific client for whom the appointment has been scheduled',
            'help' => 'Choose the client from the available list',
        ],
        'date' => [
            'label' => 'Date',
            'placeholder' => 'Select date',
            'tooltip' => 'Appointment date',
            'helper_text' => 'Specific date on which the appointment will take place',
            'help' => 'Select the appropriate date for the appointment',
        ],
        'time' => [
            'label' => 'Time',
            'placeholder' => 'Select time',
            'tooltip' => 'Appointment time',
            'helper_text' => 'Specific time when the appointment will start',
            'help' => 'Choose the most appropriate time',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Select status',
            'tooltip' => 'Current appointment status',
            'helper_text' => 'Current status of the appointment in the system',
            'help' => 'Select the appropriate status from the list',
            'options' => [
                'scheduled' => 'Scheduled',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ],
        ],
        'notes' => [
            'label' => 'Notes',
            'placeholder' => 'Enter additional notes',
            'tooltip' => 'Notes and observations about the appointment',
            'helper_text' => 'Additional information or special notes about the appointment',
            'help' => 'Add any relevant information',
        ],
        'machines_count' => [
            'label' => 'Number of Machines',
            'tooltip' => 'Number of machines involved',
            'helper_text' => 'Number of machines or devices involved in the appointment',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'tooltip' => 'Appointment creation date',
            'helper_text' => 'Date and time when the appointment was created in the system',
        ],
        'updated_at' => [
            'label' => 'Last Modified',
            'tooltip' => 'Date of last modification',
            'helper_text' => 'Date and time of the last appointment update',
        ],
    ],
    // ==============================================
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    // ==============================================
    'actions' => [
        'create' => [
            'label' => 'New Appointment',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Create a new appointment',
            'modal' => [
                'heading' => 'Create New Appointment',
                'description' => 'Enter details for the new appointment',
                'confirm' => 'Create Appointment',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Appointment created successfully',
                'error' => 'Error creating appointment',
            ],
        ],
        'edit' => [
            'label' => 'Edit Appointment',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Edit the selected appointment',
            'modal' => [
                'heading' => 'Edit Appointment',
                'description' => 'Update appointment details',
                'confirm' => 'Save changes',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Appointment updated successfully',
                'error' => 'Error updating appointment',
            ],
        ],
        'delete' => [
            'label' => 'Delete Appointment',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Delete the selected appointment',
            'modal' => [
                'heading' => 'Delete Appointment',
                'description' => 'Are you sure you want to delete this appointment? This action is irreversible.',
                'confirm' => 'Delete',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Appointment deleted successfully',
                'error' => 'Error deleting appointment',
            ],
            'confirmation' => 'Are you sure you want to delete this appointment?',
        ],
        'view' => [
            'label' => 'View Appointment',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'View appointment details',
        ],
        'confirm' => [
            'label' => 'Confirm Appointment',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
            'tooltip' => 'Confirm the selected appointment',
            'modal' => [
                'heading' => 'Confirm Appointment',
                'description' => 'Are you sure you want to confirm this appointment?',
                'confirm' => 'Confirm',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Appointment confirmed successfully',
                'error' => 'Error confirming appointment',
            ],
        ],
        'cancel' => [
            'label' => 'Cancel Appointment',
            'icon' => 'heroicon-o-x-circle',
            'color' => 'danger',
            'tooltip' => 'Cancel the selected appointment',
            'modal' => [
                'heading' => 'Cancel Appointment',
                'description' => 'Are you sure you want to cancel this appointment?',
                'confirm' => 'Cancel',
                'cancel' => 'Close',
            ],
            'messages' => [
                'success' => 'Appointment cancelled successfully',
                'error' => 'Error cancelling appointment',
            ],
        ],
        'bulk_actions' => [
            'delete' => [
                'label' => 'Delete Selected',
                'icon' => 'heroicon-o-trash',
                'color' => 'danger',
                'tooltip' => 'Delete selected appointments',
                'modal' => [
                    'heading' => 'Delete Selected Appointments',
                    'description' => 'Are you sure you want to delete the selected appointments? This action is irreversible.',
                    'confirm' => 'Delete all',
                    'cancel' => 'Cancel',
                ],
                'messages' => [
                    'success' => 'Appointments deleted successfully',
                    'error' => 'Error deleting appointments',
                ],
            ],
            'confirm' => [
                'label' => 'Confirm Selected',
                'icon' => 'heroicon-o-check-circle',
                'color' => 'success',
                'tooltip' => 'Confirm selected appointments',
                'modal' => [
                    'heading' => 'Confirm Selected Appointments',
                    'description' => 'Are you sure you want to confirm the selected appointments?',
                    'confirm' => 'Confirm all',
                    'cancel' => 'Cancel',
                ],
                'messages' => [
                    'success' => 'Appointments confirmed successfully',
                    'error' => 'Error confirming appointments',
                ],
            ],
        ],
    ],
    // ==============================================
    // SECTIONS - ORGANIZZAZIONE FORM
    // ==============================================
    'sections' => [
        'basic_info' => [
            'label' => 'Basic Information',
            'description' => 'Fundamental appointment information',
            'icon' => 'heroicon-o-information-circle',
        ],
        'schedule' => [
            'label' => 'Schedule',
            'description' => 'Date, time and temporal details',
            'icon' => 'heroicon-o-clock',
        ],
        'client_info' => [
            'label' => 'Client Information',
            'description' => 'Client details and notes',
            'icon' => 'heroicon-o-user',
        ],
    ],
    // ==============================================
    // FILTERS - RICERCA E FILTRI
    // ==============================================
    'filters' => [
        'status' => [
            'label' => 'Status',
            'options' => [
                'scheduled' => 'Scheduled',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ],
        ],
        'client' => [
            'label' => 'Client',
            'placeholder' => 'Select client',
        ],
        'date_range' => [
            'label' => 'Period',
            'placeholder' => 'Select period',
        ],
        'search' => [
            'label' => 'Search',
            'placeholder' => 'Search appointments...',
        ],
    ],
    // ==============================================
    // MESSAGES - FEEDBACK UTENTE
    // ==============================================
    'messages' => [
        'empty_state' => 'No appointments found',
        'search_placeholder' => 'Search appointments...',
        'loading' => 'Loading appointments...',
        'total_count' => 'Total appointments: :count',
        'created' => 'Appointment created successfully',
        'updated' => 'Appointment updated successfully',
        'deleted' => 'Appointment deleted successfully',
        'confirmed' => 'Appointment confirmed successfully',
        'cancelled' => 'Appointment cancelled successfully',
        'bulk_deleted' => 'Appointments deleted successfully',
        'bulk_confirmed' => 'Appointments confirmed successfully',
        'error_general' => 'An error occurred. Please try again later.',
        'error_validation' => 'Validation errors occurred.',
        'error_permission' => 'You do not have permission to perform this action.',
        'success_operation' => 'Operation completed successfully',
    ],
    // ==============================================
    // VALIDATION - MESSAGGI DI VALIDAZIONE
    // ==============================================
    'validation' => [
        'client_id_required' => 'Client is required',
        'date_required' => 'Date is required',
        'time_required' => 'Time is required',
        'status_required' => 'Status is required',
        'date_after' => 'Date must be in the future',
        'time_format' => 'Time must be in HH:MM format',
        'notes_max' => 'Notes cannot exceed :max characters',
    ],
    // ==============================================
    // DESCRIPTIONS - DESCRIZIONI CONTESTUALI
    // ==============================================
    'descriptions' => [
        'appointment_purpose' => 'Complete appointment and booking management',
        'status_workflow' => 'Status flow: Scheduled → Confirmed → Completed/Cancelled',
        'best_practices' => 'Always check availability before confirming',
        'limitations' => 'Cannot modify already completed appointments',
    ],
    // ==============================================
    // OPTIONS - OPZIONI E VALORI PREDEFINITI
    // ==============================================
    'options' => [
        'statuses' => [
            'scheduled' => 'Scheduled',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ],
        'time_slots' => [
            '09:00' => '09:00',
            '09:30' => '09:30',
            '10:00' => '10:00',
            '10:30' => '10:30',
            '11:00' => '11:00',
            '11:30' => '11:30',
            '14:00' => '14:00',
            '14:30' => '14:30',
            '15:00' => '15:00',
            '15:30' => '15:30',
            '16:00' => '16:00',
            '16:30' => '16:30',
        ],
        'priorities' => [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        ],
    ],
];
