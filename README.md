# WordPress Options Page

This repository introduces a PHP class designed to simplify the creation of custom options pages in the WordPress admin interface. Ideal for theme and plugin developers, this class enables easy integration of advanced user options.

## Features

- **Ease of Options Page Creation**: Enables the easy creation of options pages within WordPress.
- **Customizable Fields**: Supports various field types such as text, checkbox, email, color, etc.
- **Advanced Media Integration**: Specific keywords in placeholders trigger the opening of the WordPress media library.

## Installation and Setup

1. Clone or download this repository into your WordPress environment.
2. Import the class into your `functions.php` file or your plugin.

```php
require_once 'path/to/wp-options-page/class-option-page.php';
```

## Usage Example

```php
function add_params_options_page() {
    $option = new Option_Page( 'Params', 'params_options_page' );

    $option->add_field(
        'text',
        'my_param_name',
        array(
            'label'       => 'Name',
            'placeholder' => 'Enter your name',
        )
    );

    $option->add_field(
        'email',
        'my_param_email',
        array(
            'label'       => 'Email',
            'placeholder' => 'Enter your email',
        )
    );

    $option->add_field(
        'url',
        'my_param_avatar',
        array(
            'label'       => 'Avatar',
            'placeholder' => 'Select your avatar ~ 100px',
        )
    );
}
add_action( 'init', 'add_params_options_page' );
```

## Contributing

Contributions to improve this project are welcome, whether they be bug fixes, documentation improvements, or new feature suggestions.

## License

This project is distributed under the [GNU General Public License version 2 (GPL v2)](LICENSE).
