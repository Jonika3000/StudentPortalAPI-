<?php

namespace App\Traits;

trait HydrateStaticTrait
{
    public function hydrate(array $values): self
    {
        foreach ($values as $key => $value) {
            if (property_exists($this, $key) && null === $this->{$key}) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }
}
