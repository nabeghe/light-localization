# Light Localziation for PHP

> A light weight and path-based PHP localization library that translations are loaded up when needed.

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/light-localization
```

### 📁 Localization Directory

- Create a directory for localization.
- In this directory, create new folders, each of these folders actually represent Localization codes.
  They can be language codes or anything else.
- Inside each code directory, php files will be placed, each of these files has the role of a translator.
  These files can return an array or an object that implements the ArrayAccess interface. If it's an array, each key
  will represent a value, but if it's an object, each field or method is a translation key.
  The priority is with the method & it must return a value. With the method, you can have dynamic localization!

### Examples

Check the examples folder in the repositiry.

```php
use Nabeghe\LightLocalization\Localizer;

$localizer = new Localizer(__DIR__ . '/langs');
echo $localizer->get('title');
```

**Notice:** The localization code can be specified in the constructor method.
Of course, it's possible to change it later via method `recode`.

## 🧩 Features

- Get the value using the key.
- Localization code (the second parameter of Localizer constructor).
- Default translation value if the key doesn't exists,
  (the third parameter of Localizer constructor).
- Create different translators in different files.
- Reload the translator.
- Remove the loaded translator.
- Refreshing translators and reloading them.
- Changing the localization code.

## 📖 License

Copyright (c) 2023 Hadi Akbarzadeh

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.