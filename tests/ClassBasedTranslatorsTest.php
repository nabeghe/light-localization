<?php declare(strict_types=1);
require_once 'LocalizerCase.php';

final class ClassBasedTranslatorsTest extends LocalizerCase
{
    public function getTranslatorsDirectoryName(): string
    {
        return 'class';
    }

//    public function testDynamicMessage()
//    {
//        $all_expected = [
//            'Hey Honey, are you ready?',
//            'Hey Babe, Let\'s go?',
//            'Yeah darling... Come with me.',
//            'Hello Sweetheart, ready for some fun?',
//            'Hey Love, what do you think about a little adventure?',
//            'Sweetie, shall we make this a memorable day?',
//        ];
//        $translated = $this->localizer->get('message'); // from `main.php` file.
//        $this->assertContains($translated, $all_expected);
//    }
}