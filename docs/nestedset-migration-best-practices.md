# NestedSet Migration Best Practices - TechPlanner Module

## Overview

Questo documento descrive le best practices per implementare migrazioni con strutture ad albero (nested sets) nel modulo TechPlanner utilizzando il pacchetto `kalnoy/laravel-nestedset`.

## Pattern per Categorie Servizi

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Kalnoy\Nestedset\NestedSet;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\ServiceCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi categoria servizio
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia categorie
            NestedSet::columns($table);
            
            // Metadati categoria
            $table->string('icon')->nullable();
            $table->string('color')->default('#6b7280');
            $table->json('metadata')->nullable();
            
            // Configurazioni
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Struttura Organizzativa

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\OrganizationalUnit::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi unità organizzativa
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia organizzativa
            NestedSet::columns($table);
            
            // Gestione
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('headquarters_id')->nullable();
            
            // Informazioni
            $table->string('type'); // company, department, team
            $table->json('settings')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Tipi Appuntamento

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\AppointmentType::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi tipo appuntamento
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia tipi
            NestedSet::columns($table);
            
            // Durata e scheduling
            $table->integer('duration_minutes')->default(60);
            $table->json('available_slots')->nullable(); // Slot disponibili
            $table->json('buffer_times')->nullable(); // Tempi buffer
            
            // Prezzi e pagamenti
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->json('payment_methods')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Categorie Dispositivi

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\DeviceCategory::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi categoria dispositivo
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // NestedSet per gerarchia categorie
            NestedSet::columns($table);
            
            // Specifiche categoria
            $table->string('brand')->nullable();
            $table->string('model_pattern')->nullable(); // Pattern per modelli
            $table->json('required_fields')->nullable(); // Campi obbligatori
            
            // Manutenzione
            $table->integer('maintenance_interval_days')->nullable();
            $table->json('maintenance_tasks')->nullable();
            
            // Metadati
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }
};
```

## Pattern per Profili Utente Gerarchici

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\UserProfile::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Utente associato
            $table->unsignedBigInteger('user_id');
            
            // NestedSet per gerarchia profili
            NestedSet::columns($table);
            
            // Informazioni profilo
            $table->string('title')->nullable();
            $table->text('bio')->nullable();
            $table->string('department')->nullable();
            $table->string('role')->nullable();
            
            // Competenze
            $table->json('skills')->nullable();
            $table->json('certifications')->nullable();
            
            // Preferenze
            $table->json('preferences')->nullable();
            $table->boolean('is_public')->default(false);
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
```

## Integrazione con AddressItemEnum per Clienti

Integrazione con AddressItemEnum per gestione indirizzi clienti:

```php
<?php

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\Client::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi cliente
            $table->string('name')->nullable();
            $table->string('vat_number')->nullable();
            
            // Campi indirizzo usando AddressItemEnum::columns()
            AddressItemEnum::columns($table, withLegacy: false);
            
            // Contatti
            $table->string('email')->nullable()->comment('Email contatto principale');
            $table->string(AddressItemEnum::PHONE->value)->nullable();
            
            // Campi business
            $table->string('tax_code')->nullable();
            $table->string('company_name')->nullable();
            $table->string('activity')->nullable();
            
            // Stato
            $table->boolean('business_closed')->default(false);
            $table->string('competent_health_unit')->nullable();
            
            $this->addCommonFields($table);
        });
    }
};
```

## Integrazione con Modelli TechPlanner

```php
<?php

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ServiceCategory extends Model
{
    use NodeTrait;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'metadata',
        'is_active',
        'sort_order',
    ];
    
    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
    
    // Relazioni
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    
    // Scopes specifici TechPlanner
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
    
    // Metodi helper
    public function getAllServicesCount(): int
    {
        return $this->descendants()
            ->withCount('services')
            ->get()
            ->sum('services_count');
    }
    
    public function getEffectiveSettings(): array
    {
        $settings = $this->settings ?? [];
        
        foreach ($this->ancestors as $ancestor) {
            $settings = array_merge($settings, $ancestor->settings ?? []);
        }
        
        return $settings;
    }
}
```

## Best Practices Specifiche per TechPlanner

### 1. Nomenclatura Coerente

- `ServiceCategory`: Categorizzazione gerarchica servizi
- `OrganizationalUnit`: Struttura organizzativa multi-livello
- `AppointmentType`: Tipi appuntamento con durate ereditate
- `DeviceCategory`: Categorie dispositivi con manutenzione
- `UserProfile`: Profili utente gerarchici

### 2. Gestione Durate Ereditate

```php
// Durata effettiva ereditata da parent
public function getEffectiveDuration(): int
{
    if ($this->duration_minutes) {
        return $this->duration_minutes;
    }
    
    return $this->parent?->getEffectiveDuration() ?? 60;
}
```

### 3. Validazioni Codici Univoci

```php
// Validazione codice univoco nella gerarchia
public function setCodeAttribute($value)
{
    if ($value) {
        $exists = static::where('code', $value)
            ->where(function ($query) {
                $query->whereNull('parent_id')
                    ->orWhereIn('parent_id', $this->ancestors()->pluck('id'));
            })
            ->exists();
            
        if ($exists) {
            throw new \Exception("Code '{$value}' already exists in hierarchy");
        }
    }
    
    $this->attributes['code'] = $value;
}
```

### 4. Indici per Performance TechPlanner

```php
// Indici ottimizzati per query TechPlanner
$table->index(['parent_id', 'is_active']);
$table->index('code');
$table->index('slug');
$table->index('type');
$table->index(['user_id', 'is_active']);
```

## Pattern per Appuntamenti con Location

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\LocationAppointment::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi appuntamento
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            
            // Campi geografici usando AddressItemEnum::columns()
            AddressItemEnum::columns($table, withLegacy: true);
            
            // Dettagli appuntamento
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('technician_id');
            $table->string('status')->default('scheduled');
            
            // Metadati
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('technician_id')->references('id')->on('users');
        });
    }
};
```

## Pattern per Dispositivi con Indirizzo

```php
<?php

return new class extends XotBaseMigration
{
    protected ?string $model_class = \Modules\TechPlanner\Models\LocationDevice::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi dispositivo
            $table->string('serial_number')->unique();
            $table->string('model');
            $table->string('brand');
            
            // Campi geografici usando AddressItemEnum::columns()
            AddressItemEnum::columns($table, withLegacy: true);
            
            // Dettagli dispositivo
            $table->date('purchase_date')->nullable();
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            
            // Stato
            $table->string('status')->default('active');
            $table->json('configuration')->nullable();
            
            $table->timestamps();
        });
    }
};
```

## Riferimenti

- [Documentazione principale](/docs/migration/nestedset-best-practices.md)
- [TechPlanner Module Architecture](/docs/architecture/techplanner-module.md)
- [AddressItemEnum Integration](/docs/address-item-enum-integration.md)