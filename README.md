# WordPress Options Page

This repository introduces a PHP class designed to simplify the creation of custom options pages in the WordPress admin interface. Ideal for theme and plugin developers, this class enables easy integration of advanced user options.

## Features

- **Ease of Options Page Creation**: Enables the easy creation of options pages within WordPress.
- **Customizable Fields**: Supports various field types such as textarea, select, text, checkbox, email, color, etc.
- **Advanced Media Integration**: Specific keywords in placeholders trigger the opening of the WordPress media library.
- **Sections Grouping**: Group fields into titled sections for clearer organization.

## Installation and Setup

1. Clone or download this repository into your WordPress environment.
2. Import the class into your `functions.php` file or your plugin.

```php
require_once 'path/to/wp-options-page/class-option-page.php';
```

## Usage Example

```php
function add_site_options_page() {
    $option = new Option_Page( 'Site Settings', 'site_settings' );

    // Sections for organization
    $option->add_section( 'general', 'General' );
    $option->add_section( 'contact', 'Contact' );
    $option->add_section( 'social', 'Social Networks' );

    // Text and media integration
    $option->add_field( 'text', 'site_tagline', array( 'label' => 'Tagline', 'section' => 'general' ) );
    $option->add_field( 'url', 'site_logo', array( 'label' => 'Logo', 'placeholder' => 'Select image ~ 200px', 'section' => 'general' ) );
    $option->add_field( 'color', 'brand_color', array( 'label' => 'Brand color', 'section' => 'general' ) );
    $option->add_field( 'checkbox', 'maintenance_mode', array( 'label' => 'Maintenance mode', 'section' => 'general' ) );

    // Select with options
    $option->add_field( 'select', 'layout', array(
        'label' => 'Layout',
        'options' => array( 'grid' => 'Grid', 'list' => 'List' ),
        'section' => 'general'
    ) );

    // Contact fields
    $option->add_field( 'email', 'contact_email', array( 'label' => 'Email', 'section' => 'contact' ) );
    $option->add_field( 'textarea', 'address', array( 'label' => 'Address', 'rows' => 3, 'section' => 'contact' ) );

    // Social URLs
    $option->add_field( 'url', 'facebook_url', array( 'label' => 'Facebook', 'section' => 'social' ) );
    $option->add_field( 'url', 'twitter_url', array( 'label' => 'Twitter', 'section' => 'social' ) );

    // Field without section
    $option->add_field( 'textarea', 'custom_css', array( 'label' => 'Custom CSS', 'rows' => 8 ) );
}
add_action( 'init', 'add_site_options_page' );
```

## Contributing

Contributions to improve this project are welcome, whether they be bug fixes, documentation improvements, or new feature suggestions.

## License

This project is distributed under the [GNU General Public License version 2 (GPL v2)](LICENSE).
