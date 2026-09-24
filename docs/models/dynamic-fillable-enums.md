# Managing Dynamic Fillable Properties with Enums in Laraxot Models

This document outlines a professional approach for handling model `$fillable` properties dynamically, especially when fields are derived from PHP Enums, ensuring adherence to Laraxot principles (DRY, KISS, SOLID) and promoting maintainability.

## 1. The Challenge: Static `$fillable` vs. Dynamic Enum Fields

Eloquent's `$fillable` property is typically a static array of column names. However, in a modular and enum-driven architecture like Laraxot, many model fields might correspond directly to enum cases (e.g., `AddressItemEnum` defining address parts, `ContactTypeEnum` defining contact fields, `CompanyItemEnum` defining company details).

Manually updating `$fillable` every time an enum changes or a new enum is introduced leads to:
- **Violation of DRY**: Repeating enum field names in multiple places.
- **Maintenance Overhead**: Increased effort and potential for errors during updates.
- **Tight Coupling**: Models become tightly coupled to specific enum implementations.

## 2. Current Pattern (Client Model - AddressItemEnum Example)

The `Client` model currently demonstrates a dynamic approach for `AddressItemEnum` fields by overriding the `getFillable()` method:

```php
// In Modules/TechPlanner/app/Models/Client.php

use Modules\Geo\Enums\AddressItemEnum;
use Illuminate\Support\Arr;
// ... other imports

class Client extends BaseModel
{
    // ...
    protected $fillable = [
        'name',
        'vat_number',
        'fiscal_code',
        // ... other static fillable fields
    ];

    /**
     * Dynamically extends the fillable properties with fields from AddressItemEnum.
     */
    public function getFillable(): array
    {
        $enumFields = Arr::map(AddressItemEnum::cases(), fn ($item) => $item->value);
        return array_merge(parent::getFillable(), $enumFields);
    }
    // ...
}
```

This pattern is effective for a single enum, providing dynamism and adhering to DRY for `AddressItemEnum`.

## 3. Professional Approach: Centralized Dynamic `Fillable` Trait

To generalize this approach for multiple enums (like `ContactTypeEnum`, `CompanyItemEnum`) and keep models clean, a dedicated trait is recommended. This trait centralizes the logic for merging enum-defined fields into the `$fillable` array.

### Proposed Trait: `Modules\Xot\Models\Traits\HasDynamicFillable`

This trait would live in the `Xot` module, making it available across the entire Laraxot ecosystem.

```php
// Conceptual example - DO NOT ADD CODE TO THIS DOCUMENT.
// Filename: Modules/Xot/app/Models/Traits/HasDynamicFillable.php

namespace Modules\Xot\Models\Traits;

use Illuminate\Support\Arr;

trait HasDynamicFillable
{
    /**
     * Overrides the default getFillable method to include fields from specified Enums.
     *
     * Models using this trait should define a protected array property `$dynamicFillableEnums`
     * containing the fully qualified class names of Enums whose cases should be added to fillable.
     *
     * Example: protected array $dynamicFillableEnums = [AddressItemEnum::class, ContactTypeEnum::class];
     *
     * @return array<int, string>
     */
    public function getFillable(): array
    {
        $fillable = parent::getFillable();

        // Ensure the property exists and is an array
        if (! property_exists($this, 'dynamicFillableEnums') || ! is_array($this->dynamicFillableEnums)) {
            return $fillable;
        }

        foreach ($this->dynamicFillableEnums as $enumClass) {
            // Basic validation for enum class
            if (! enum_exists($enumClass)) {
                continue; // Skip invalid enum classes
            }

            // Get enum cases' values and merge
            $enumFields = Arr::map($enumClass::cases(), fn ($item) => $item->value);
            $fillable = array_merge($fillable, $enumFields);
        }

        // Ensure unique values and reset keys for cleanliness
        return array_values(array_unique($fillable));
    }
}
```

### 4. Implementing the Trait in Models (e.g., `Client` Model)

With the `HasDynamicFillable` trait, the `Client` model's `fillable` management becomes much cleaner and more extensible:

```php
// In Modules/TechPlanner/app/Models/Client.php

namespace Modules\TechPlanner\Models;

use Modules\Xot\Models\Traits\HasDynamicFillable;
use Modules\Geo\Enums\AddressItemEnum;
// use Modules\Notify\Enums\ContactTypeEnum; // Assuming this enum exists
// use Modules\TechPlanner\Enums\CompanyItemEnum; // Assuming this enum exists

class Client extends BaseModel
{
    use HasDynamicFillable; // Use the new trait
    // ... other traits

    // Define which enums contribute to the dynamic fillable fields
    protected array $dynamicFillableEnums = [
        AddressItemEnum::class,
        // ContactTypeEnum::class, // Add other enums as needed
        // CompanyItemEnum::class, // Add other enums as needed
    ];

    protected $fillable = [
        'name',
        'vat_number',
        'fiscal_code',
        'business_closed',
        'company_name',
        'competent_health_unit',
        'tax_code',
        'assigned_worker_id',
        'notes',
        'administrative_reference',
        // Fields that are specific to the Client model and not derived from any enum
        // or fields that are not part of a dedicated section.
    ];

    // The getFillable() method is now handled by the HasDynamicFillable trait.
    // ... other model methods
}
```

### 5. Benefits of this Approach

*   **DRY Compliant**: Enum cases are defined once in their respective enums and automatically included in `$fillable`.
*   **Highly Maintainable**: Adding or removing fields from an enum automatically updates the `fillable` array without requiring changes to the model.
*   **Extensible**: Easily add support for new enums by simply listing them in the `$dynamicFillableEnums` property.
*   **Clearer Model Definition**: The `$fillable` array in the model becomes primarily for fields *not* derived from shared enums, improving readability.
*   **Laraxot Philosophy**: Aligns with the modular and convention-driven approach of Laraxot.

## 6. Considerations

*   **Enum Existence**: The trait should gracefully handle cases where an enum class specified in `$dynamicFillableEnums` does not exist. (Addressed with `enum_exists` check).
*   **Performance**: The dynamic `getFillable()` method is called on model instantiation. For a large number of models or very complex enums, this could have a minor performance impact, though typically negligible. Caching mechanisms could be explored if profiling reveals issues.
*   **Mass Assignment Protection**: This approach still relies on the developer to correctly list enums. Ensure all fields from the listed enums are indeed safe for mass assignment within the model's context.

This structured approach provides a robust and scalable way to manage `fillable` properties in Laraxot models, embracing the power of Enums and promoting clean architecture.
