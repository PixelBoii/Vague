# Vague

Admin panel for laravel projects.

## Installation

1. Add the repository to your composer.json file:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/PixelBoii/Vague.git"
    }
],
```

2. Require the package using composer:

```bash
composer require pixelboii/vague
```

3. Publish the required files:

```bash
php artisan vendor:install
```

1. You're done! The app should now be accessible through the `/vague` route.

## Usage

1. Add Vague files for the models you want to manage:

```bash
php artisan vague:resource User
```

2. Register the vague files in your `config/vague.php` file:

```php
...
'resources' => [
    App\Vague\User::class,
],
...
```

### Permissions

If you want to use the permissions system, you'll need to add the `HasPermissions` trait to your user model:

```php
use PixelBoii\Vague\Traits\HasPermissions;
```

The permissions feature is enabled by default in the config file but can be disabled by removing it from the `features` array.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
