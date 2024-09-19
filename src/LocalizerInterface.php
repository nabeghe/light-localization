<?php namespace Nabeghe\LightLocalization;

/**
 * Localizer interface.
 * @package Nabeghe\LightLocalization
 */
interface LocalizerInterface
{
    /**
     * Default translator name.
     */
    public const DEFAULT_TRANSLATOR = 'main';

    /**
     * Default translator code.
     */
    public const DEFAULT_CODE = 'generic';

    /**
     * Retrieves the root path.
     */
    public function getPath();

    /**
     * Retrieves the current language code.
     */
    public function getCode();

    /**
     * Changes the localization code.
     * @param  string  $code  New code.
     * @param  bool  $refresh  Optional. After changing the code, should it reload the loaded translators or remove all of them from the loaded state? Default false.
     */
    public function setCode(string $code, bool $refresh = false);

    /**
     * Retrieves the default translation.
     */
    public function getDefaultTranslation();

    /**
     * Retrieves the list of loaded translators.
     * @return array
     */
    public function getTranslators(): array;

    /**
     * Retrieves the file path of a translator.
     * @param  string  $translator  Optional. The translator file name without `.php` extension. Default `main`.
     * @return string
     */
    public function getTranslatorPath(string $translator = self::DEFAULT_TRANSLATOR);

    /**
     * Checks whether the translator exists or not.
     * @param  string  $translator  Translator Translator file name.
     * @return bool
     */
    public function translatorExists(string $translator = self::DEFAULT_TRANSLATOR);

    /**
     * Checks if a translator is loaded before or not.
     * @param  string  $translator  Translator file name.
     * @return bool
     */
    public function isLoaded(string $translator);

    /**
     * Loads a translator even if it is already loaded.
     * @param  string  $translator  Translator file name.
     * @return bool
     */
    public function load($translator = self::DEFAULT_TRANSLATOR);

    /**
     * Loads all loaded translators from the beginning.
     */
    public function refresh();

    /**
     * Removes a translator from loaded state.
     * @param  string  $translator  Translator file name.
     * @return bool
     */
    public function unload(string $translator = self::DEFAULT_TRANSLATOR);

    /**
     * Checks whether a key exists in a translator or not.
     * @param  string  $key
     * @param  string  $translator  Translator file name.
     * @return bool
     */
    public function has(string $key, $translator = self::DEFAULT_TRANSLATOR);

    /**
     * Retrieves a string or translation using its key.
     * @param  string  $key  The key is in the translator.
     * @param  string  $translator  Translator file name.
     * @return string|mixed
     */
    public function get(string $key, string $translator = self::DEFAULT_TRANSLATOR);

    /**
     * It's's similar to the {@see self::get()} method, with the difference that if the output is an array, it randomly returns one of the values within it.
     * @param  string  $key
     * @param  string  $translator
     * @return mixed|Localizer|string
     */
    public function rnd(string $key, string $translator = self::DEFAULT_TRANSLATOR);
}