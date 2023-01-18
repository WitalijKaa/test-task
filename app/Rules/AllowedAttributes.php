<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowedAttributes implements Rule
{
    public function __construct(private array $attributeNames) {
    }

    public function passes($attribute, $value)
    {
        return in_array($attribute, $this->attributeNames);
    }

    public function message()
    {
        return 'Attribute is not allowed :attribute';
    }
}
