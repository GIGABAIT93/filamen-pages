# Filament Pages

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gigabait93/filament-pages.svg?style=flat-square)](https://packagist.org/packages/gigabait93/filament-pages)
[![Total Downloads](https://img.shields.io/packagist/dt/gigabait93/filament-pages.svg?style=flat-square)](https://packagist.org/packages/gigabait93/filament-pages)

A powerful and flexible page builder plugin for Filament Admin that allows you to create dynamic, multi-language pages with a block-based content system.

## Features

- 🏗️ **Block-based Page Builder** - Create pages using reusable content blocks
- 🌍 **Multi-language Support** - Built-in translation system for international websites
- 📱 **Responsive Design** - Mobile-friendly page layouts
- 🎨 **Rich Content Blocks** - Text, Images, Gallery, Video, Hero sections, and more
- 🔧 **Customizable Templates** - Create and use custom block templates
- 🧭 **Navigation Integration** - Automatic navigation menu generation
- 👁️ **Visibility Control** - Control page visibility and access
- 🎯 **Position Management** - Drag and drop page ordering

## Screenshots
<img width="1920" height="8050" alt="FireShot Capture 002 - Edit - StarterKit - gigabait uk" src="https://github.com/user-attachments/assets/ab9358f3-a358-4ba3-b5e1-7e1d15484067" />
<img width="1920" height="4367" alt="FireShot Capture 001 - StarterKit - gigabait uk" src="https://github.com/user-attachments/assets/f314b11b-f20b-4647-b3bb-3d7daafee66e" />


## Installation

You can install the package via composer:

```bash
composer require gigabait93/filament-pages
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-pages-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-pages-config"
```

Optionally, you can publish the views using:

```bash
php artisan vendor:publish --tag="filament-pages-views"
```

You can publish the language files using:

```bash
php artisan vendor:publish --tag="filament-pages-translations"
```

This is the contents of the published config file:

```php
<?php

return [
    // Group label for pages in the Filament admin navigation. Set to
    // `null` to display pages without a group.
    'admin_navigation_group' => null,

    // Position of the pages group within the admin navigation menu.
    'admin_navigation_order' => 5,

    // Icon for the pages group in the admin navigation menu.
    'admin_navigation_icon' => 'heroicon-o-document-text',


    // Filament panel identifiers that should register the client-side
    // plugin. Uncomment and list your panel IDs below.
    'clients_panels_ids' => [
        // 'client',
    ],

    // The Eloquent model representing application users.
    'user_model' => \App\Models\User::class,
];
```

## Usage

### Admin Panel Setup

Register the plugin in your Admin Panel Provider:

```php
use Gigabait93\FilamentPages\AdminPagesPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(AdminPagesPlugin::make());
}
```

### Client Panel Setup

Register the plugin in your Client Panel Provider:

```php
use Gigabait93\FilamentPages\ClientPagesPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(ClientPagesPlugin::make());
}
```

### Service Provider Registration

Make sure to register the service provider in your `config/app.php`:

```php
'providers' => [
    // ...
    Gigabait93\FilamentPages\Providers\FilamentPagesServiceProvider::class,
],
```

Or if you're using Laravel 11's automatic package discovery, this will be handled automatically.

### Creating Pages

1. Navigate to the **Pages** section in your Filament admin panel
2. Click **"New Page"** to create a page
3. Fill in the basic information:
   - **Name**: The display name of the page
   - **Slug**: URL-friendly identifier
   - **Template**: Choose from available templates
   - **Status**: Active/Inactive
   - **Position**: Order in navigation

4. Add content blocks by clicking **"Add Block"** and choosing from:
   - **Text Block**: Rich text content
   - **Markdown Text Block**: Markdown formatted text
   - **Image Block**: Single image with caption
   - **Gallery Block**: Multiple images gallery
   - **Video Block**: Video embedding
   - **Hero Block**: Large banner section
   - **Button Block**: Call-to-action buttons
   - **Two Columns Block**: Side-by-side content
   - **Divider Block**: Section separators

### Multi-language Support

The plugin supports multi-language pages:

1. Configure available locales in the config file
2. Create translations for each page
3. Content blocks are automatically translatable
4. Use the language switcher in the admin interface

### Available Content Blocks

#### Text Block
Rich text editor with formatting options:

- Rich text content
- Typography controls
- Link management
- List formatting


#### Image Block
Single image with options:

- Image upload
- Alt text for SEO
- Caption text
- Image sizing options


#### Gallery Block
Multiple image showcase:

- Multiple image upload
- Image ordering
- Lightbox functionality
- Grid layout options


#### Video Block
Video embedding:

- YouTube/Vimeo URLs
- Local video upload
- Autoplay options
- Responsive sizing


#### Hero Block
Large banner sections:

- Background image/video
- Overlay text
- Call-to-action buttons
- Alignment options


#### Button Block
Call-to-action elements:

- Button text and URL
- Style variants
- Icon support
- Target options


### Custom Templates

You can create custom block templates:

1. Publish the views: `php artisan vendor:publish --tag="filament-pages-views"`
2. Create new template directories in `resources/views/vendor/pages/blocks/`
3. Add your custom Blade templates
4. Templates will be automatically discovered

Example custom template structure:
```
resources/views/vendor/pages/blocks/
├── custom-template/
│   ├── text.blade.php
│   ├── image.blade.php
│   └── gallery.blade.php
```

### Helper Functions

The plugin provides several helper functions:

#### page_normalize_blocks()
Normalizes block content array:
```php
$blocks = page_normalize_blocks($page->content);
```

#### page_media_url()
Generates media URLs:
```php
$url = page_media_url($imagePath, 'public');
```

#### templatesOptions()
Gets available templates:
```php
$templates = templatesOptions();
```

#### iconsOptions()
Gets available Heroicons:
```php
$icons = iconsOptions();
```

### Frontend Display

To display pages on the frontend, the plugin automatically registers routes. You can also manually create routes:

```php
use Gigabait93\FilamentPages\Pages\Show;

Route::get('/p/{slug?}', Show::class)->name('pages.show');
```

### Customizing Views

Publish and customize the views:

```bash
php artisan vendor:publish --tag="filament-pages-views"
```

The main page view is located at:
```
resources/views/vendor/pages/show.blade.php
```

Block templates are located at:
```
resources/views/vendor/pages/blocks/
```

### Navigation Integration

Pages are automatically added to navigation menus. You can control this behavior:

1. Set navigation group in page settings
2. Choose navigation icon
3. Set navigation position
4. Enable/disable navigation visibility

## Credits

- [Gigabait93](https://github.com/gigabait93)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Filament Plugin Directory

This plugin is listed in the [Filament Plugin Directory](https://filamentphp.com/plugins/gigabait93-filament-pages).
