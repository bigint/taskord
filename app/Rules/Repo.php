<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Repo implements Rule
{
    public function passes($attribute, $value)
    {
        return Str::contains($value, ['github.com/', 'gitlab.com/', 'bitbucket.org/']);
    }

    public function message()
    {
        return 'Repo should be GitHub / GitLab / Bitbucket URL';
    }
}
