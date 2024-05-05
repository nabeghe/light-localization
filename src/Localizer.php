<?php namespace Nabeghe\LightLocalization;

/**
 * Localizer class.
 * @package Nabeghe\LightLocalization
 */
class Localizer
{
    /**
     * Default translator name.
     */
    public const DEFAULT_TRANSLATOR = 'main';

    /**
     * The root path, where the directories related to the language codes are located.
     * @var string
     */
    protected string $path;

    /**
     * Current language code.
     * @var string
     */
    protected string $code;

    /**
     * Default translation that can be a string or another localizer.
     * If the key is not found in the translation, the default will be used.
     * If the default is a string, the string itself will be returned instead of the default translation,
     * but if it's a localizer object, it's `get` method will be used to retrieve the translation.
     * @see self::get()
     * @var Localizer|string
     */
    protected $defaultTranslation;

    /**
     * A list of loaded translators.
     * @var array
     */
    protected array $translators = [];

    /**
     * Retrieves the root path.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Retrieves the current language code.
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Changes the localization code.
     * @param  string  $code  New code.
     * @param  bool  $refresh  Optional. After changing the code, should it reload the loaded translators or remove all of them from the loaded state? Default false.
     */
    public function setCode(string $code, bool $refresh = false): void
    {
        $this->code = $code;
        if ($refresh) {
            $this->refresh();
        } else {
            $this->translators = [];
        }
    }

    /**
     * An alias for the {@see setcode}
     */
    public function recode(string $code, bool $refresh = false): void
    {
        $this->setCode($code, $refresh);
    }

    /**
     * Retrieves the default translation.
     */
    public function getDefaultTranslation()
    {
        return $this->defaultTranslation;
    }

    /**
     * Retrieves the list of loaded translators.
     * @return array
     */
    public function getTranslators(): array
    {
        return $this->translators;
    }

    /**
     * Constructor.
     * @param  string  $path  The root path where the directories related to the codes are located.
     * @param  string  $code  Optional. Localization code. Default `generic`.
     * @param  Localizer|string  $defaultTranslation  Optional. Default translation. Default is empty string.
     */
    public function __construct(string $path, string $code = 'generic', $defaultTranslation = '')
    {
        $this->path = rtrim($path, '/');
        $this->code = $code;
        $this->defaultTranslation = $defaultTranslation;
    }

    /**
     * Retrieves the file path of a translator.
     * @param  string  $translator  Optional. The translator file name without `.php` extension. Default `main`.
     * @return string
     */
    public function getTranslatorPath(string $translator = self::DEFAULT_TRANSLATOR): string
    {
        return "$this->path/$this->code/$translator.php";
    }

    /**
     * Checks whether the translator exists or not.
     * @param  string  $translator  Translator Translator file name.
     * @return bool
     */
    public function translatorExists(string $translator = self::DEFAULT_TRANSLATOR): bool
    {
        return file_exists($this->getTranslatorPath($translator));
    }

    /**
     * Checks if a translator is loaded before or not.
     * @param  string  $translator  Translator file name.
     * @return bool
     */
    public function isLoaded(string $translator): bool
    {
        return isset($this->translators[$translator]);
    }

    /**
     * Loads a translator even if it is already loaded.
     * @param  string  $translator  Translator file name.
     * @return bool
     */
    public function load($translator = self::DEFAULT_TRANSLATOR): bool
    {
        $success = false;
        $branch_path = $this->getTranslatorPath($translator);
        if (file_exists($branch_path)) {
            $new_data = include $branch_path;
            if (!$new_data) {
                $new_data = [];
            } else {
                $success = true;
            }
        }
        $this->translators[$translator] = $new_data ?? [];
        return $success;
    }

    /**
     * Loads all loaded translators from the beginning.
     */
    public function refresh(): void
    {
        $translators_names = array_keys($this->translators);
        foreach ($translators_names as $translator_name) {
            $this->load($translator_name);
        }
    }

    /**
     * Removes a translator from loaded state.
     * @param  string  $translator  Translator file name.
     * @return bool
     */
    public function unload(string $translator = self::DEFAULT_TRANSLATOR): bool
    {
        if (isset($this->translators[$translator])) {
            unset($this->translators[$translator]);
            return true;
        }
        return false;
    }

    /**
     * Checks whether a key exists in a translator or not.
     * @param  string  $key
     * @param  string  $translator  Translator file name.
     * @return bool
     */
    public function has(string $key, $translator = self::DEFAULT_TRANSLATOR)
    {
        if (!isset($this->translators[$translator])) {
            $this->load($translator);
        }
        return isset($this->translators[$translator][$key])
            || (!is_string($this->defaultTranslation) && $this->defaultTranslation->has($key, $translator));
    }

    /**
     * Retrieves a string or translation using its key.
     * @param  string  $key  The key is in the translator.
     * @param  string  $translator  Translator file name.
     * @return string|mixed
     */
    public function get(string $key, string $translator = self::DEFAULT_TRANSLATOR)
    {
        if (!isset($this->translators[$translator])) {
            $this->load($translator);
        }
        if (isset($this->translators[$translator][$key])) {
            return $this->translators[$translator][$key];
        }
        if (is_string($this->defaultTranslation)) {
            return $this->defaultTranslation;
        }
        return $this->defaultTranslation->get($key, $translator);
    }
}