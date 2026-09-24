# TechPlanner Module - Filament v4 Upgrade Notes

This document outlines specific considerations and changes for the `TechPlanner` module during the Filament v4 upgrade process. For a comprehensive overview of the Filament v4 upgrade, refer to the main project documentation: [`docs/filament_v4_upgrade.md`](../../../docs/filament_v4_upgrade.md).

## **Key Changes and Action Items for `TechPlanner` Module**

### **1. Adherence to Laraxot `XotBaseSection` Rule**

*   **Rule:** According to Laraxot philosophy, all custom Filament Section components **must extend `Modules\Xot\Filament\Schemas\Components\XotBaseSection`** instead of directly extending `Filament\Schemas\Components\Section`. This ensures architectural consistency and leverages shared `XotBaseSection` functionalities.
*   **Status:**
    *   `CompanySection` (`Modules\TechPlanner\Filament\Forms\Components\CompanySection.php`): Already extends `XotBaseSection`.
    *   `AddressSection` (`Modules\Geo\Filament\Forms\Components\AddressSection.php`): Already extends `XotBaseSection`.
    *   `ContactSection` (`Modules\Notify\Filament\Forms\Components\ContactSection.php`): Already extends `XotBaseSection`.
    *   The core rule is correctly applied in these components.

### **2. Resolution of `BadMethodCallException` (`disableLiveUpdates`)**

*   **Issue:** A `BadMethodCallException` occurred in `CompanySection` (traced through `XotBaseSection`), indicating that `disableLiveUpdates()` was being called on a component that did not possess this method in Filament v4. This method was present in older Filament versions or expected as a macro.
*   **Resolution:** A dummy `public function disableLiveUpdates(): static` method was added to `Modules\Xot\Filament\Schemas\Components\XotBaseSection.php`. This acts as a compatibility shim, preventing the `BadMethodCallException` at runtime when this method is invoked (implicitly or explicitly) by Filament's lifecycle or macros, without requiring its original v3 functionality. This ensures smooth operation of `CompanySection` and other `XotBaseSection`-derived components.

### **3. Filament v4 Section Component Behavior (`columnSpanFull`)**

*   **Issue:** In Filament v3, `Section` components automatically spanned the full width of their parent grid. In Filament v4, `Section` components now only consume one column by default.
*   **Action Required:** Review all instances where `CompanySection` is used within `TechPlanner` forms. If a `CompanySection` (or any `XotBaseSection`-derived component) is intended to span the full width, the `->columnSpanFull()` method must be explicitly called on its instance.
    ```php
    use Modules\TechPlanner\Filament\Forms\Components\CompanySection;

    // ... in your form schema
    CompanySection::make('company')
        ->columnSpanFull(),
    ```
    For a global return to v3 behavior, this can be configured in a service provider (e.g., `AppServiceProvider`):
    ```php
    use Filament\Schemas\Components\Section;

    Section::configureUsing(fn (Section $section) => $section->columnSpanFull());
    ```

---
**DRY (Don't Repeat Yourself) / KISS (Keep It Simple, Stupid) Principles:**

*   **`XotBaseSection` as Base:** Extending `XotBaseSection` centralizes common functionalities and ensures consistent behavior for all custom section components, adhering to DRY.
*   **Compatibility Shim:** Adding `disableLiveUpdates()` to `XotBaseSection` is a KISS approach to resolving a version incompatibility without requiring complex refactoring across all child components, or modifying core Filament behavior.
*   **Explicit Spanning:** Explicitly calling `columnSpanFull()` promotes clarity and avoids implicit behaviors that can change across versions, improving robustness.

By following these guidelines, the `TechPlanner` module maintains its architectural integrity and adapts gracefully to Filament v4 changes.
