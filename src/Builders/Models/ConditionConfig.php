<?php

namespace Zhelyazko777\Tables\Builders\Models;

class ConditionConfig
{
    /**
     * @var array<string, mixed>
     */
    private array $conditions = [];

    /**
     * @return array<string, mixed>
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param  array<string, mixed>  $conditions
     * @return ConditionConfig
     */
    public function setConditions(array $conditions): ConditionConfig
    {
        $this->conditions = $conditions;
        return $this;
    }
}
