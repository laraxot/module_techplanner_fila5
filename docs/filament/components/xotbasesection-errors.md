# XotBaseSection Common Errors and Solutions

## Error: BadMethodCallException - disableLiveUpdates does not exist

### Problem
```
BadMethodCallException - Internal Server Error
Method Modules\TechPlanner\Filament\Forms\Components\CompanySection::disableLiveUpdates does not exist.
```

### Root Cause
The `disableLiveUpdates()` method doesn't exist in Filament v4 Section components. This method was either:
1. Removed in Filament v4
2. Never existed in the base Section class
3. Only available in specific Filament components

### Solution
**Remove the `disableLiveUpdates` property or method call from custom Section components.**

#### Before (❌ WRONG):
```php
class CompanySection extends XotBaseSection
{
    protected bool $disableLiveUpdates = false; // ❌ This property doesn't exist
    // OR
    protected function setUp(): void
    {
        parent::setUp();
        $this->disableLiveUpdates(false); // ❌ This method doesn't exist
    }
}
```

#### After (✅ CORRECT):
```php
class CompanySection extends XotBaseSection
{
    protected function setUp(): void
    {
        parent::setUp();
        // Setup your section without disableLiveUpdates
        $this->schema(fn (): array => $this->getFormSchema());
        $this->columns(2);
    }
}
```

### Key Learning Points
1. **XotBaseSection extends Filament Section**: All methods available in Filament Section are available, but no additional methods unless explicitly defined in XotBaseSection.
2. **Check Filament Documentation**: Always verify method existence in the current Filament version being used.
3. **Pattern Consistency**: Follow the enum-driven pattern for form schemas to maintain DRY principles.
4. **No Magic Properties**: Don't assume properties exist without checking the parent class.

### Related Documentation
- [Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [XotBaseSection Philosophy](../architecture/laraxot-philosophy.md)
- [Enum-Driven Form Pattern](../patterns/enum-driven-forms.md)