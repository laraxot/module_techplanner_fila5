# Dynamic Fillable Fields with Enums

This document describes the professional and robust pattern implemented in the `TechPlanner` module for managing Eloquent `fillable` properties dynamically using PHP Enums. This approach ensures data consistency, reduces redundancy, and enhances maintainability, especially for models with many attributes derived from enumerations.

## **Pattern: `HasDynamicFillable` Trait with `dynamicFillableEnums`**

### **1. Purpose**

Traditional management of `$fillable` arrays in Eloquent models can become cumbersome and error-prone when fields directly correspond to values defined within PHP Enums (e.g., address components, contact types). This pattern centralizes the definition of such fields within their respective Enums and dynamically injects them into the model's `$fillable` array.

This solves several problems:
*   **DRY (Don't Repeat Yourself):** Avoids duplicating field names in both the Enum and the model's `$fillable` array.
*   **Consistency:** Ensures that any field defined in an Enum that should be fillable is automatically included.
*   **Maintainability:** Changes to Enum values automatically reflect in the model's fillable attributes without manual updates.
*   **Architectural Alignment:** Promotes a cleaner separation of concerns where Enums are the single source of truth for their defined values.

### **2. How it Works**

The core of this pattern is the `Modules\Xot\Models\Traits\HasDynamicFillable` trait.

1.  **`HasDynamicFillable` Trait:** This trait, when used in an Eloquent model, intercepts the `getFillable()` method (or similar lifecycle hooks) to dynamically append fields.
2.  **`$dynamicFillableEnums` Property:** Models using this trait define a `protected array $dynamicFillableEnums` property. This array specifies a list of `class-string<\UnitEnum>` (i.e., PHP Enum classes) that contain values intended to be part of the model's fillable attributes.
3.  **Enum Integration:** For each Enum class listed in `$dynamicFillableEnums`, the trait expects a mechanism (e.g., a static method like `cases()` or a method that returns its values) to retrieve all relevant enum values (e.g., `'phone'`, `'email'`, `'street_number'`).
4.  **Dynamic Merge:** The trait then takes these enum values and merges them with the model's existing `protected $fillable` array, effectively creating a comprehensive list of fillable attributes at runtime.

### **3. Example Implementation in `Client` Model**

The `Modules\TechPlanner\Models\Client` model is a prime example of this pattern:

```php
// laravel/Modules/TechPlanner/app/Models/Client.php
<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

// ... other imports
use Modules\Geo\Enums\AddressItemEnum; // Import the Enum
use Modules\Xot\Models\Traits\HasDynamicFillable; // Import the trait

class Client extends BaseModel
{
    // ... other traits
    use HasDynamicFillable; // Use the trait

    /**
     * Define which enums contribute to the dynamic fillable fields.
     *
     * @var array<int, class-string<\UnitEnum>>
     */
    protected array $dynamicFillableEnums = [
        AddressItemEnum::class, // List the Enum classes here
        // ContactTypeEnum::class, // If ContactTypeEnum fields also need to be fillable
        // CompanyItemEnum::class, // If CompanyItemEnum fields also need to be fillable
    ];

    protected $fillable = [
        'name',
        'vat_number',
        'fiscal_code',
        // ... statically defined fillable fields
    ];

    // ... rest of the model
}
```

### **4. Example Enum (`AddressItemEnum`)**

An example of an Enum that supports this pattern is `Modules\Geo\Enums\AddressItemEnum`:

```php
// laravel/Modules/Geo/app/Enums/AddressItemEnum.php
<?php

declare(strict_types=1);

namespace Modules\Geo\Enums;

use UnitEnum; // PHP 8.1+ built-in interface

enum AddressItemEnum: string implements UnitEnum // Or similar interface
{
    case ROUTE = 'route';
    case STREET_NUMBER = 'street_number';
    case LOCALITY = 'locality';
    // ... other address components

    // The HasDynamicFillable trait will typically iterate over `self::cases()`
    // or a method like `self::getFillableValues()` if explicitly defined,
    // to get the string values of the enum cases.
}
```

### **5. Benefits of this Approach**

*   **Single Source of Truth:** `AddressItemEnum` (and similar enums) becomes the definitive list of fields for address components, contact types, etc.
*   **Automatic Synchronization:** Adding or removing a case in `AddressItemEnum` automatically updates the `Client` model's `$fillable` array.
*   **Reduced Boilerplate:** Less manual array management in model files.
*   **Improved Readability:** Model definitions become cleaner and focus on core attributes, delegating dynamic parts to enums.
*   **Enhanced Type Safety (with PHPStan/Psalm):** When combined with proper type hinting and `Webmozart\Assert`, this pattern supports robust static analysis by clearly defining expected field types and sources.

## **Conclusion**

The `HasDynamicFillable` trait, coupled with a well-defined `dynamicFillableEnums` property, provides an elegant and effective solution for managing dynamic fillable attributes in Eloquent models. It embodies DRY and KISS principles by centralizing field definitions and automating their integration, leading to a more maintainable and architecturally sound codebase.
