# WordPress Options Page

A lightweight PHP class for creating custom options pages in the WordPress admin area.

## Features

- Text, email, url, number, color, checkbox, textarea, select fields
- Group fields into sections
- Media library integration via placeholder keywords
- Automatic image size selection
- Built-in sanitization per field type

## Setup

```php
require_once 'path/to/wp-options-page/class-option-page.php';
```

## Usage

```php
$option = new Option_Page( 'Site Settings', 'site_settings' );

$option->add_section( 'general', 'General' );

$option->add_field( 'text', 'site_tagline', array( 'label' => 'Tagline', 'section' => 'general' ) );
$option->add_field( 'color', 'brand_color', array( 'label' => 'Brand color', 'section' => 'general' ) );

$option->add_field( 'email', 'contact_email', array( 'label' => 'Email' ) );
$option->add_field( 'select', 'layout', array( 'label' => 'Layout', 'choices' => array( 'grid', 'list' ) ) );
```

## License

[GPL v2](LICENSE)
