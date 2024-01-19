<?php

namespace Nabeghe\LightLocalization;

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
     * The root path where the directories related to the codes are located.
     * @var string
     */
    protected string $path;

    /**
     * Current directory code
     * @var string
     */
    protected string $code;

    /**
     * The default translation returned if the requested key (translation) doesn't exist.
     * @see self::get()
     * @var mixed
     */
    protected $defaultTranslation;

    /**
     * Loaded translators.
     * @var array
     */
    protected array $translators = [];

    /**
     * Gets the translators list.
     * @return array
     */
    public function getTranslators(): array
    {
        return $this->translators;
    }

    /**
     * Constructor.
     * @param string $path The root path where the directories related to the codes are located.
     * @param string $code Optional. Localization code. Default generic.
     * @param string $default_translation Optional. The default translation returned if the requested key (translation) doesn't exist.. Default empty string.
     */
    public function __construct(string $path, string $code = 'generic', $default_translation = '')
    {
        $this->path = rtrim($path, '/');
        $this->code = $code;
        $this->defaultTranslation = $default_translation;
    }

    /**
     * Gets the file path of a translator.
     * @param string $translator_name Optional. The translator name. Default main.
     * @return string
     */
    public function getTranslatorPath($translator_name = self::DEFAULT_TRANSLATOR): string
    {
        return "$this->path/$this->code/$translator_name.php";
    }

    /**
     * Checks if a translator is loaded or not.
     * @param $translator_name
     * @return bool
     */
    public function isLoaded($translator_name): bool
    {
        return isset($this->translators[$translator_name]);
    }

    /**
     * Loads a translator even if it is already loaded.
     * @param string $translator_name
     * @return bool
     */
    public function load($translator_name = self::DEFAULT_TRANSLATOR): bool
    {
        $siccess = false;
        $branch_path = $this->getTranslatorPath($translator_name);
        if (file_exists($branch_path)) {
            $new_data = include $branch_path;
            if (!$new_data) {
                $new_data = [];
            } else {
                $siccess = true;
            }
        }
        $this->translators[$translator_name] = $new_data ?? [];
        return $siccess;
    }

    /**
     * Loads all loaded translators from the beginning.
     */
    public function refresh()
    {
        $translators_names = array_keys($this->translators);
        foreach ($translators_names as $translator_name) {
            $this->load($translator_name);
        }
    }

    /**
     * Removes a translator from loaded state.
     * @param string $translator_name
     * @return bool
     */
    public function unload($translator_name = self::DEFAULT_TRANSLATOR): bool
    {
        if (isset($this->translators[$translator_name])) {
            unset($this->translators[$translator_name]);
            return true;
        }
        return false;
    }

    /**
     * Changes the localization code.
     * @param string $code
     * @param bool $refresh Optional. After changing the code, should it reload the loaded translators or remove all of them from the loaded state? Default false.
     */
    public function recode($code, $refresh = false)
    {
        $this->code = $code;
        if ($refresh) {
            $this->refresh();
        } else {
            $this->translators = [];
        }
    }

    /**
     * @param string $key The key is in the translator.
     * @param string $translator_name
     * @return string|mixed
     */
    public function get(string $key, $translator_name = self::DEFAULT_TRANSLATOR)
    {
        if (!isset($this->translators[$translator_name])) {
            $this->load($translator_name);
        }
        return $this->translators[$translator_name][$key] ?? $this->defaultTranslation;
    }
}