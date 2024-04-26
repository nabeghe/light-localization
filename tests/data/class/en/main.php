<?php return new class extends \Nabeghe\LightLocalization\Translator {

    public string $title = 'Light Localization';

    public string $description = 'A light weight, key-value & path-based PHP localization library that translations are loaded up when needed.';

    public function message()
    {
        $msgs = [
            'Hey Honey, are you ready?',
            'Hey Babe, Let\'s go?',
            'Yeah darling... Come with me.',
            'Hello Sweetheart, ready for some fun?',
            'Hey Love, what do you think about a little adventure?',
            'Sweetie, shall we make this a memorable day?',
        ];
        return $msgs[array_rand($msgs)];
    }

};