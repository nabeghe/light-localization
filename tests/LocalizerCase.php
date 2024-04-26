<?php declare(strict_types=1);

use Nabeghe\LightLocalization\Localizer;
use PHPUnit\Framework\TestCase;

abstract class LocalizerCase extends TestCase
{
    protected Localizer $localizer;

    public abstract function getTranslatorsDirectoryName(): string;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->localizer = new Localizer(
            __DIR__.'/data/'.$this->getTranslatorsDirectoryName(),
            'fa',
            new Localizer(__DIR__.'/data/'.$this->getTranslatorsDirectoryName(), 'en'),
        );
        parent::__construct($name, $data, $dataName);
    }

    public function testForGet(): void
    {
        $expected = 'لایت لوکالیزیشن';
        $translated = $this->localizer->get('title'); // from `main.php` file.
        $this->assertSame($expected, $translated);
    }

    public function testForDefaultTranslation(): void
    {
        $expected = 'A light weight, key-value & path-based PHP localization library that translations are loaded up when needed.';
        $translated = $this->localizer->get('description'); // from `main.php` file.
        $this->assertSame($expected, $translated);
    }

    public function testForDifferentTranslator(): void
    {
        $expected = 'Hadi Akbarzadeh';
        $translated = $this->localizer->get('name', 'developer'); // from `names.php` file.
        $this->assertSame($expected, $translated);
    }
}