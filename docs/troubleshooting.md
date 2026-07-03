# TechPlanner Troubleshooting Guide

## Common Issues and Solutions

### Installation Issues

#### Module Not Loading
**Problem**: TechPlanner module doesn't appear in the module list

**Symptoms**:
- Module not showing in Filament admin
- Routes not registered
- Models not found

**Solutions**:
1. Check if module is enabled:
```bash
php artisan module:list
```

2. Enable module if disabled:
```bash
php artisan module:enable TechPlanner
```

3. Clear caches:
```bash
php artisan config:clear
php artisan route:clear
php artisan module:publish TechPlanner
```

4. Check composer autoloader:
```bash
composer dump-autoload
```

#### Migration Issues
**Problem**: Database migrations fail

**Symptoms**:
- SQL errors during migration
- Tables not created
- Foreign key constraints errors

**Solutions**:
1. Check migration status:
```bash
php artisan module:migrate-status TechPlanner
```

2. Reset and re-run migrations:
```bash
php artisan module:migrate:reset TechPlanner
php artisan module:migrate TechPlanner
```

3. Check for conflicts with other modules:
```bash
php artisan migrate:status
```

#### Duplicate Column Error (created_at/updated_at)
**Problem**: `SQLSTATE[42S21]: Column already exists: 1060 Duplicate column name 'created_at'`

**Symptoms**:
- Migration fails with duplicate column error
- Error occurs when trying to add `created_at` or `updated_at`
- Table already has timestamp columns

**Root Cause**:
The migration code checks only for `updated_at` before calling `timestamps()`, but `timestamps()` adds BOTH `created_at` and `updated_at`. If `created_at` already exists, this causes the error.

**Example of Problematic Code**:
```php
// ❌ ERRATO - Verifica solo updated_at
if (! $this->hasColumn('updated_at')) {
    $table->timestamps(); // Aggiunge ENTRAMBE le colonne!
}
```

**Solution**:
Use `updateTimestamps()` method from `XotBaseMigration` which correctly checks BOTH columns:

```php
// ✅ CORRETTO - Usa updateTimestamps() che verifica entrambe le colonne
$this->updateTimestamps($table, true);
```

**Fixed Pattern**:
```php
// ❌ RIMUOVERE codice duplicato:
if (! $this->hasColumn('updated_at')) {
    $table->timestamps();
}
if (! $this->hasColumn('updated_by')) {
    $table->string('updated_by')->nullable();
}
if (! $this->hasColumn('created_by')) {
    $table->string('created_by')->nullable();
}

// ✅ MANTENERE solo questo:
$this->updateTimestamps($table, true); // Gestisce tutto correttamente
```

**Why This Works**:
The `updateTimestamps()` method in `XotBaseMigration` correctly checks:
- Both `created_at` AND `updated_at` before adding `timestamps()`
- `updated_by` and `created_by` columns separately
- Uses proper `foreignIdFor()` instead of `string()` for user references

**Related Files**:
- `laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php` (line 270)
- `laravel/Modules/TechPlanner/database/migrations/2019_12_12_000004_create_workers_table.php` (fixed)

#### Foreign Key to Non-Existent Table Error
**Problem**: `SQLSTATE[HY000]: General error: 1824 Failed to open the referenced table 'clients'`

**Symptoms**:
- Migration fails when trying to create foreign key constraint
- Error occurs in CREATE block when referencing a table that doesn't exist yet
- Table order issue: migration with earlier timestamp references table created later

**Root Cause**:
The migration tries to create a foreign key constraint in the CREATE block, but the referenced table (`clients`) doesn't exist yet because it's created in a migration with a later timestamp.

**Example of Problematic Code**:
```php
// ❌ ERRATO - Foreign key nel CREATE block
$this->tableCreate(function (Blueprint $table): void {
    $table->foreignId('client_id')->constrained()->cascadeOnDelete();
});
```

**Solution**:
Create the column in CREATE block, add foreign key constraint in UPDATE block only if referenced table exists:

```php
// ✅ CORRETTO - Colonna nel CREATE, FK nel UPDATE
$this->tableCreate(function (Blueprint $table): void {
    // Solo la colonna, senza foreign key constraint
    $table->unsignedBigInteger('client_id')->nullable()->index();
});

$this->tableUpdate(function (Blueprint $table): void {
    // Aggiungere FK solo se la tabella referenziata esiste
    if ($this->hasTable('clients')) {
        $table->foreign('client_id')
            ->references('id')
            ->on('clients')
            ->onDelete('cascade');
    }
});
```

**Why This Works**:
- The UPDATE block runs after all CREATE blocks, so referenced tables should exist
- Using `hasTable()` ensures we only add the constraint if the table exists
- The column is created first, then the constraint is added conditionally

**Migration Order**:
- Migrations are executed in timestamp order (filename order)
- If `appointments` (2019) needs `clients` (2024), the FK must be added in UPDATE block
- Always check table existence before adding foreign key constraints

**Related Files**:
- `laravel/Modules/TechPlanner/database/migrations/2019_12_12_000005_create_appointments_table.php` (fixed)
- `laravel/Modules/TechPlanner/database/migrations/2024_12_26_000000_create_phone_call_table.php` (fixed)
- `laravel/Modules/TechPlanner/database/migrations/2024_12_26_000001_create_device_table.php` (fixed)

**Note**: Le migrazioni con timestamp successivi a `2024_12_26_000008_create_client_table.php` possono creare foreign key direttamente nel blocco CREATE perché la tabella `clients` esiste già.

### Runtime Issues

#### Client Creation Fails
**Problem**: Cannot create new clients

**Symptoms**:
- Validation errors
- Database insert failures
- Duplicate entry errors

**Solutions**:
1. Check validation rules:
```php
// In CreateClientRequest
'vat_number' => ['required', 'string', new ValidVatNumber()],
'email' => ['required', 'email', 'unique:clients'],
```

2. Verify database schema:
```sql
DESCRIBE clients;
SHOW INDEX FROM clients;
```

3. Check for soft deletes:
```php
// Make sure you're not checking soft-deleted records
Client::withTrashed()->get();
```

#### Appointment Scheduling Conflicts
**Problem**: Double booking or overlapping appointments

**Symptoms**:
- Two appointments at same time
- Technician overbooked
- Resources not available

**Solutions**:
1. Implement availability check:
```php
public function isAvailable($technicianId, $startTime, $duration)
{
    $endTime = $startTime->copy()->addMinutes($duration);
    
    $conflicts = Appointment::where('technician_id', $technicianId)
        ->where('status', '!=', 'cancelled')
        ->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('scheduled_date', [$startTime, $endTime])
                  ->orWhere('scheduled_date', '<', $startTime)
                  ->whereRaw('scheduled_date + INTERVAL duration MINUTE > ?', [$startTime]);
        })
        ->count();
        
    return $conflicts === 0;
}
```

2. Add database constraints:
```sql
ALTER TABLE appointments ADD CONSTRAINT check_no_overlaps 
CHECK (/* complex check logic */);
```

#### Device Compliance Issues
**Problem**: Compliance status not updating correctly

**Symptoms**:
- Devices showing as compliant when expired
- Inspection dates not updating
- Notifications not sending

**Solutions**:
1. Check compliance calculation:
```php
public function updateComplianceStatus()
{
    $this->is_compliant = $this->next_inspection > now()->addDays(30);
    $this->save();
    
    event(new DeviceComplianceUpdated($this));
}
```

2. Verify scheduled jobs:
```bash
php artisan schedule:list
php artisan schedule:run
```

3. Check notification channels:
```bash
php artisan notifications:table
php artisan migrate
```

### Performance Issues

#### Slow Client Queries
**Problem**: Client list loading slowly

**Symptoms**:
- Page load > 3 seconds
- Memory usage high
- Database timeouts

**Solutions**:
1. Add database indexes:
```sql
CREATE INDEX idx_clients_active ON clients(is_active);
CREATE INDEX idx_clients_city ON clients(city);
CREATE INDEX idx_clients_business_name ON clients(business_name);
```

2. Use eager loading:
```php
$clients = Client::with(['appointments', 'devices'])
    ->where('is_active', true)
    ->paginate(50);
```

3. Implement caching:
```php
$clients = Cache::remember('active_clients', 3600, function () {
    return Client::where('is_active', true)->get();
});
```

#### Appointment Calendar Performance
**Problem**: Calendar view loading slowly

**Symptoms**:
- Month view takes > 5 seconds
- Browser freezing
- High CPU usage

**Solutions**:
1. Optimize query:
```php
$appointments = Appointment::with(['client', 'technician'])
    ->whereBetween('scheduled_date', [$startDate, $endDate])
    ->orderBy('scheduled_date')
    ->get()
    ->groupBy(function ($appointment) {
        return $appointment->scheduled_date->format('Y-m-d');
    });
```

2. Use database view:
```sql
CREATE VIEW appointment_calendar AS
SELECT 
    DATE(scheduled_date) as date,
    COUNT(*) as count,
    GROUP_CONCAT(DISTINCT technician_id) as technicians
FROM appointments 
WHERE status != 'cancelled'
GROUP BY DATE(scheduled_date);
```

3. Implement pagination for large datasets:
```php
$appointments = Appointment::paginate(100);
```

### Integration Issues

#### Filament Resource Not Showing
**Problem**: TechPlanner resources not appearing in admin panel

**Symptoms**:
- Menu items missing
- 404 errors on resource pages
- Permission denied errors

**Solutions**:
1. Check provider registration:
```php
// In TechPlannerServiceProvider
protected $resources = [
    \Modules\TechPlanner\Filament\Resources\ClientResource::class,
    \Modules\TechPlanner\Filament\Resources\AppointmentResource::class,
    \Modules\TechPlanner\Filament\Resources\DeviceResource::class,
];
```

2. Verify permissions:
```php
// In Filament Panel Provider
public function panel(Panel $panel): Panel
{
    return $panel
        ->resources([
            ClientResource::class,
            AppointmentResource::class,
            DeviceResource::class,
        ])
        ->authMiddleware([
            'auth:sanctum',
            config('filament.auth.middleware'),
        ], true);
}
```

3. Clear view cache:
```bash
php artisan view:clear
php artisan filament:cache-components
```

#### Notification System Not Working
**Problem**: Emails/SMS not sending

**Symptoms**:
- Queue jobs failing
- No notifications received
- Error logs showing connection issues

**Solutions**:
1. Check mail configuration:
```bash
php artisan config:cache
php artisan tinker
>>> Mail::raw('Test', function($msg) { $msg->to('test@example.com'); });
```

2. Verify queue system:
```bash
php artisan queue:failed
php artisan queue:retry all
```

3. Test notification channel:
```php
$user = User::first();
$user->notify(new AppointmentReminder($appointment));
```

### Data Issues

#### Duplicate Client Records
**Problem**: Same client appears multiple times

**Symptoms**:
- Search returns duplicates
- Reports incorrect counts
- Foreign key conflicts

**Solutions**:
1. Find duplicates:
```sql
SELECT business_name, vat_number, COUNT(*) 
FROM clients 
GROUP BY business_name, vat_number 
HAVING COUNT(*) > 1;
```

2. Merge duplicates:
```php
public function mergeClients($primaryId, $duplicateIds)
{
    $primary = Client::find($primaryId);
    
    foreach ($duplicateIds as $id) {
        $duplicate = Client::find($id);
        
        // Move relationships
        $duplicate->appointments()->update(['client_id' => $primaryId]);
        $duplicate->devices()->update(['client_id' => $primaryId]);
        
        // Delete duplicate
        $duplicate->delete();
    }
}
```

3. Add unique constraint:
```sql
ALTER TABLE clients ADD UNIQUE INDEX idx_vat_number (vat_number);
```

#### Orphaned Records
**Problem**: Records without valid parent references

**Symptoms**:
- Null reference errors
- Data integrity issues
- Report inconsistencies

**Solutions**:
1. Find orphaned records:
```sql
SELECT a.id FROM appointments a 
LEFT JOIN clients c ON a.client_id = c.id 
WHERE c.id IS NULL;

SELECT d.id FROM devices d 
LEFT JOIN clients c ON d.client_id = c.id 
WHERE c.id IS NULL;
```

2. Clean up orphaned records:
```php
Appointment::whereNotIn('client_id', Client::pluck('id'))->delete();
Device::whereNotIn('client_id', Client::pluck('id'))->delete();
```

3. Add foreign key constraints:
```sql
ALTER TABLE appointments 
ADD CONSTRAINT fk_appointments_client 
FOREIGN KEY (client_id) REFERENCES clients(id) 
ON DELETE CASCADE;
```

## Debugging Tools

### Logging
Enable detailed logging:
```php
// In config/logging.php
'channels' => [
    'techplanner' => [
        'driver' => 'daily',
        'path' => storage_path('logs/techplanner.log'),
        'level' => 'debug',
    ],
],
```

Use in code:
```php
Log::channel('techplanner')->debug('Client created', [
    'client_id' => $client->id,
    'user_id' => auth()->id(),
]);
```

### Telescope Integration
```php
// In AppServiceProvider
if (app()->environment('local')) {
    Telescope::filter(function (IncomingEntry $entry) {
        return $entry->type === 'request' ||
               $entry->type === 'exception' ||
               str_contains($entry->content['class'], 'TechPlanner');
    });
}
```

### Debug Bar
```bash
composer require --dev barryvdh/laravel-debugbar
```

## Monitoring

### Health Checks
```php
// In routes/web.php
Route::get('/health/techplanner', function () {
    return [
        'status' => 'ok',
        'checks' => [
            'database' => DB::connection()->getPdo() ? 'ok' : 'error',
            'queue' => Queue::size() < 100 ? 'ok' : 'warning',
            'cache' => Cache::get('health_check') ? 'ok' : 'error',
        ],
    ];
});
```

### Metrics to Monitor
1. Appointments per day
2. Client acquisition rate
3. Device compliance percentage
4. Notification delivery rate
5. API response times

## Emergency Procedures

### Database Recovery
1. Stop the application:
```bash
php artisan down
```

2. Restore from backup:
```bash
mysql database_name < backup.sql
```

3. Run migrations:
```bash
php artisan migrate --force
```

4. Clear caches:
```bash
php artisan cache:clear
php artisan config:clear
```

5. Bring application back:
```bash
php artisan up
```

### Rollback Module Update
1. Reset module migrations:
```bash
php artisan module:migrate:reset TechPlanner
```

2. Checkout previous version:
```bash
git checkout previous_tag
```

3. Reinstall dependencies:
```bash
composer install
```

4. Run migrations:
```bash
php artisan module:migrate TechPlanner
```

#### Storage Permissions Error
**Problem**: `file_put_contents(/path/to/storage/framework/views/...): Failed to open stream: Permission denied`

**Symptoms**:
- Laravel cannot write to storage directories
- View compilation fails
- Cache operations fail
- File uploads fail

**Root Cause**:
The web server (PHP-FPM) user doesn't have write permissions to the `storage` and `bootstrap/cache` directories.

**Solution**:
Set correct permissions and ownership for storage directories:

```bash
# Fix storage permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/

# Verify permissions
ls -la storage/
ls -la bootstrap/cache/

# Test write permissions
touch storage/framework/views/test.php && rm storage/framework/views/test.php
```

**For Production**:
```bash
# More restrictive permissions (recommended for production)
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/

# Ensure subdirectories are writable
find storage -type d -exec chmod 775 {} \;
find storage -type f -exec chmod 664 {} \;
find bootstrap/cache -type d -exec chmod 775 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;
```

**Verify Fix**:
```bash
# Clear view cache to test
php artisan view:clear

# Should output: "Compiled views cleared successfully."
```

**Prevention**:
- Always set correct permissions after deployment
- Include permission fix in deployment script
- Verify permissions in CI/CD pipeline

**Related Files**:
- `docs/deployment-and-environment-configuration.md` - General deployment guide
- `deploy.sh` - Deployment script (should include permission fix)

#### Missing getTableColumns() Method Error
**Problem**: `BadMethodCallException - Method ...ListLegalOffices::getTableColumns does not exist`

**Symptoms**:
- Error occurs when accessing Resource as RelationManager
- Error in `XotBaseRelationManager::getTableColumns()` at line 128
- Resource works fine in main list view but fails in RelationManager context

**Root Cause**:
`XotBaseRelationManager` calls `getTableColumns()` on the List page to get table columns. If the method doesn't exist, it throws `BadMethodCallException`. This happens when:
1. List page doesn't implement `getTableColumns()`
2. Resource is used as RelationManager (e.g., `LegalOfficesRelationManager`)
3. `XotBaseRelationManager` tries to reuse columns from main List page

**Business Logic Context**:
- **LegalOffice**: Ufficio legale di riferimento per clienti con esigenze legali complesse
- **LegalRepresentative**: Rappresentante legale dell'azienda cliente, obbligatorio per alcune tipologie
- Both are used as RelationManagers in `ClientResource` to manage legal compliance contacts

**Solution**:
Implement `getTableColumns()` in the List page following the established pattern:

```php
class ListLegalOffices extends XotBaseListRecords
{
    protected static string $resource = LegalOfficeResource::class;

    /**
     * Get table columns for LegalOffice list.
     * REQUIRED when Resource is used as RelationManager.
     *
     * @return array<string, TextColumn>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->sortable()
                ->searchable(),
            'city' => TextColumn::make('city')
                ->sortable()
                ->searchable(),
            'province' => TextColumn::make('province')
                ->sortable()
                ->searchable(),
            'phone' => TextColumn::make('phone')
                ->searchable(),
            'email' => TextColumn::make('email')
                ->searchable()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }
}
```

**Pattern Requirements**:
1. **Array associativo**: Chiavi stringa univoche per ogni colonna
2. **Return type**: `array<string, TextColumn>`
3. **PHPDoc**: Documentare il metodo con `@return array<string, TextColumn>`
4. **Colonne rilevanti**: Mostrare campi più importanti per la business logic

**Why This Pattern**:
- **DRY**: Riutilizza colonne tra vista principale e RelationManager
- **Coerenza**: Stessa visualizzazione in entrambi i contesti
- **Manutenibilità**: Un solo punto di definizione delle colonne
- **Type Safety**: PHPStan compliance con tipi espliciti

**Related Files**:
- `laravel/Modules/TechPlanner/app/Filament/Resources/LegalOfficeResource/Pages/ListLegalOffices.php` (fixed)
- `laravel/Modules/TechPlanner/app/Filament/Resources/LegalRepresentativeResource/Pages/ListLegalRepresentatives.php` (fixed)
- `laravel/Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php` (line 128)
- `laravel/Modules/TechPlanner/docs/filament-resources.md` - Pattern documentation

## Contact Support

If issues persist:
1. Check logs: `storage/logs/laravel.log`
2. Review recent changes: `git log --oneline -10`
3. Collect system info: `php artisan about`
4. Create issue with:
   - Error messages
   - Steps to reproduce
   - System information
   - Relevant logs