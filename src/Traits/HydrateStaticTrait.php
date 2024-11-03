<?php

namespace App\Traits;

trait HydrateStaticTrait
{
    public static function hydrate(array $values): self
    {
        $element = new self();

        foreach ($values as $key => $value) {
            if (property_exists($element, $key)) {
                $element->{$key} = $value;
            }
        }

        return $element;
    }
}
