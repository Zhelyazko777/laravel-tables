<?php

namespace Zhelyazko777\Tables\Builders;

use Zhelyazko777\Tables\Builders\Models\ConditionConfig;
use Zhelyazko777\Utilities\Contracts\CanExport;

class ConditionBuilder implements CanExport
{
    private ConditionConfig $config;

    public function __construct()
    {
        $this->config = new ConditionConfig();
    }

    /**
     * Adds single condition, if called multiple times
     * it will use only the last condition
     * @param  array<string|null>  $condition
     * @return $this
     */
    public function singleCondition(array $condition): self
    {
        $addedConditions = ['and' => [$condition]];
        $this->config->setConditions($addedConditions);

        return $this;
    }

    /**
     * Adds and conditions
     * @param  array<mixed>  $conditions
     * @param  callable|null  $callback
     * @return ConditionBuilder
     */
    public function setAnd(array $conditions, ?callable $callback = null): self
    {
        $addedConditions = $this->config->getConditions();
        if (!array_key_exists('and', $addedConditions)) {
            $addedConditions['and'] = [];
        }

        if (is_array($conditions[0])) {
            foreach ($conditions as $condition)
            {
                $addedConditions['and'][] = $condition;
            }
        } else {
            $addedConditions['and'][] = $conditions;
        }

        if (!is_null($callback)) {
            $builder = new ConditionBuilder();
            $callback($builder);
            $result = $builder->export()->getConditions();
            $addedConditions['and'][] = $result;
        }

        $this->config->setConditions($addedConditions);

        return $this;
    }

    /**
     * Adds or conditions
     * @param  array<mixed>  $conditions
     * @param  callable|null  $callback
     * @return ConditionBuilder
     */
    public function setOr(array $conditions, ?callable $callback = null): self
    {
        $addedConditions = $this->config->getConditions();
        if (!array_key_exists('or', $addedConditions)) {
            $addedConditions['or'] = [];
        }

        if (is_array($conditions[0])) {
            foreach ($conditions as $condition)
            {
                $addedConditions['or'][] = $condition;
            }
        } else {
            $addedConditions['or'][] = $conditions;
        }

        if (!is_null($callback)) {
            $builder = new ConditionBuilder();
            $callback($builder);
            $result = $builder->export()->getConditions();
            $addedConditions['or'][] = $result;
        }
        $this->config->setConditions($addedConditions);

        return $this;
    }

    /**
     * Exports the configuration
     * @return ConditionConfig
     */
    public function export(): ConditionConfig
    {
        return $this->config;
    }
}
