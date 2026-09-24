# Client Management Updates

## Notification System
Added support for sending bulk notifications to clients.

### Features
- Bulk Select Clients
- Choose Notification Template (MailTemplate)
- Choose Channels (SMS, Mail, WhatsApp)

### Implementation Details
- Uses `Modules\Notify\Filament\Actions\SendNotificationBulkAction`.
- Triggers `Modules\Notify\Actions\SendRecordNotificationAction`.
