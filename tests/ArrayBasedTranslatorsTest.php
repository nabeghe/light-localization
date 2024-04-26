<?php declare(strict_types=1);
require_once 'LocalizerCase.php';

final class ArrayBasedTranslatorsTest extends LocalizerCase
{
    public function getTranslatorsDirectoryName(): string
    {
        return 'array';
    }
}