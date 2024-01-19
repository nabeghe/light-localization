<?php

use Nabeghe\LightLocalization\Translator;

return new class extends Translator {
    public string $title = 'Light Localization';

    public string $primary_btn_title = 'Yes';

    public string $secondary_btn_title = 'No';

    public string $success = 'Welcome';

    public string $unsuccess = 'Bye';

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