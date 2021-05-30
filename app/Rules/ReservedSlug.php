<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ReservedSlug implements Rule
{
    public function passes($attribute, $value)
    {
        return ! in_array($value, config('taskord.reserved_slugs'));
    }

    public function message()
    {
        return 'This slug is reserved internally!';
    }
}
