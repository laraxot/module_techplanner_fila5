# Content Block Management (Filament Builder)

The frontend content for TechPlanner is driven by JSON configuration files located in:
`config/local/techplanner/database/content/pages/`

## Home Page (home.json)
The home page content is managed via `home.json`. This file contains blocks that are rendered using the **Filament Builder** component.

### Key Concepts
- **Data-Driven UI**: Content is separated from presentation.
- **Filament Builder**: Used in the backoffice to manage these blocks.
- **Dynamic Rendering**: The `[slug].blade.php` Folio page uses `x-page` to render these JSON blocks.

### Adding New Blocks
1. Define the block schema in the Filament resource/page using `Builder\Block`.
2. Map the block name to a Blade component in the theme.
3. Update the JSON file with the new block data.

### References
- [Filament Builder Documentation](https://filamentphp.com/docs/5.x/forms/builder)
- [Modular Architecture](../architecture.md)
