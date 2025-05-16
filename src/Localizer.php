<?php namespace Nabeghe\LightLocalization;

/**
 * Localizer class.
 * @package Nabeghe\LightLocalization
 */
class Localizer implements LocalizerInterface
{
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
     * @var Localizer|string
     * @see self::get()
     */
    protected $defaultTranslation;

    /**
     * A list of loaded translators.
     * @var array
     */
    protected array $translators = [];

    public function getPath(): string
    {
        return $this->path;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code, bool $refresh = false): void
    {
        if ($this->code == $code) {
            return;
        }

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

    public function getDefaultTranslation()
    {
        return $this->defaultTranslation;
    }

    public function getTranslators(): array
    {
        return $this->translators;
    }

    /**
     * Constructor.
     * @param  string  $path  The root path where the directories related to the codes are located.
     * @param  string  $code  Optional. Localization code. Default `generic`.
     * @param  Localizer|string  $defaultTranslation  Optional. Default translation. Default value is an emoty string.
     */
    public function __construct(string $path, string $code = self::DEFAULT_CODE, $defaultTranslation = '')
    {
        $this->path = rtrim($path, '/');
        $this->code = $code;
        $this->defaultTranslation = $defaultTranslation;
    }

    public function getTranslatorPath(string $translator = self::DEFAULT_TRANSLATOR): string
    {
        return "$this->path/$this->code/$translator.php";
    }

    public function translatorExists(string $translator = self::DEFAULT_TRANSLATOR): bool
    {
        return file_exists($this->getTranslatorPath($translator));
    }

    public function isLoaded(string $translator): bool
    {
        return isset($this->translators[$translator]);
    }

    public function load($translator = self::DEFAULT_TRANSLATOR): bool
    {
        $success = false;

        $translator_path = $this->getTranslatorPath($translator);
        if (file_exists($translator_path)) {
            $new_data = include $translator_path;
            if (!is_array($new_data)) {
                $new_data = [];
            } else {
                $success = true;
            }
        }

        $this->translators[$translator] = $new_data ?? [];

        return $success;
    }

    public function refresh(): void
    {
        $translators_names = array_keys($this->translators);
        foreach ($translators_names as $translator_name) {
            $this->load($translator_name);
        }
    }

    public function unload(string $translator = self::DEFAULT_TRANSLATOR): bool
    {
        if (isset($this->translators[$translator])) {
            unset($this->translators[$translator]);
            return true;
        }

        return false;
    }

    public function has(string $key, $translator = self::DEFAULT_TRANSLATOR, bool $checkDefault = true): bool
    {
        if (!isset($this->translators[$translator])) {
            $this->load($translator);
        }

        return isset($this->translators[$translator][$key])
            || ($checkDefault && !is_string($this->defaultTranslation) && $this->defaultTranslation->has($key, $translator, $checkDefault));
    }

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

    public function rnd(string $key, string $translator = self::DEFAULT_TRANSLATOR)
    {
        $text = $this->get($key, $translator);
        if (!is_array($text)) {
            return $text;
        }

        if ($text) {
            return $text[array_rand($text)];
        }

        if (is_string($this->defaultTranslation)) {
            return $this->defaultTranslation;
        }

        return $this->defaultTranslation->get($key, $translator);
    }
}