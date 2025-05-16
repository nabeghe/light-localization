# Light Localziation for PHP

> A light weight, key-value & path-based PHP localization library that translations are loaded up when needed.

## 🫡 Usage

### 🚀 Installation

You can install the package via composer:

```bash
composer require nabeghe/light-localization
```

### 📁 Localization Directory

- Create a directory for localization.
- In this directory, create new folders, each of these folders actually represent localization codes.
  They can be language codes or anything else.
- Inside each code directory, php files will be placed, each of these files has the role of a translator.
  - These files can return an array or an object that inheritance from `Nabeghe\LightLocalization\Translator` class.
  - If it's an array, each key is a translation key & it will represent a value,
    but if it's an object, each field or method is a translation key.
    The priority is with the method & it must return a value.
  - Objects can implement the `ArrayAccess` interface in addition to inheriting from the mentioned class.

```php
use Nabeghe\LightLocalization\Localizer;

/*
 * Example of Translations Directory:
 | /langs/
 |      /en/
 |          main.php
 |          messages.php
 |      /fa/
 |          main.php
 |          messages.php
 */

$defaultLocalizer = new Localizer(__DIR__.'/langs', 'en');
$localizer = new Localizer(__DIR__.'/langs', 'fa', $defaultLocalizer);

// value of `title` key, from `main.php` translation file (default value for second argument).
echo $localizer->get('title');

// value of `hello` key, from `messages.php` translation file.
echo $localizer->get('hello', 'messages');
```

**Notice:** The localization code can be specified in the constructor method.
Of course, it's possible to change it later via method `setCode`.

**Notice:** For each localizer, a default localizer can be specified in the constructor.
Additionally, instead of specifying a default localizer, a string can be designated as the default translation.

## 🧩 Features

- Get the value (translation) using the key.
- Fetch random translations from keys with array of strings using the `rnd` method instead of `get`.
- Localization code (the second parameter of Localizer constructor).
- Default translation that can be a string or another localizer.
  (the third parameter of Localizer constructor).
- Create different translators in different files and array-based or class-based translations.
- Dynamic translations.
- Reload the translator.
- Remove the loaded translator.
- Refreshing translators and reloading them.
- Changing the localization code.

## 📖 License

Copyright (c) 2024 Hadi Akbarzadeh

Licensed under the MIT license, see [LICENSE.md](LICENSE.md) for details.