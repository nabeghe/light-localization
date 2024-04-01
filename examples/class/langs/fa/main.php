<?php

use Nabeghe\LightLocalization\Translator;

return new class extends Translator {
    public string $title = 'لایت لوکالیزیشن';

    public string $primary_btn_title = 'بله';

    public string $secondary_btn_title = 'خیر';

    public string $success = 'خوش اومدی';

    public string $unsuccess = 'بای';

    public function message()
    {
        $msgs = [
            'سلام عسلم، آماده‌ای؟',
            'هی عزیزم، بریم؟',
            'آره عزیزم... با من بیا.',
            'سلام عزیزم، برای تفریح آماده‌ای؟',
            'هی عشقم، نظرت در مورد یک ماجراجویی کوچک چیست؟',
            'عزیزم، آیا این روز را به یک روز به یاد ماندنی تبدیل کنیم؟',
        ];
        return $msgs[array_rand($msgs)];
    }
};