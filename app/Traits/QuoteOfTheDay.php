<?php

namespace App\Traits;

use Illuminate\Foundation\Inspiring;

trait QuoteOfTheDay {

    private static function getQuote()
    {
        return strip_tags(Inspiring::quote());
    }
}
