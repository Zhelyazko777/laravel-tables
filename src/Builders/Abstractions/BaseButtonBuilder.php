<?php

namespace Zhelyazko777\Tables\Builders\Abstractions;

use Zhelyazko777\Utilities\Contracts\CanExport;
use Zhelyazko777\Tables\Builders\ConditionBuilder;
use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseButtonConfig;

abstract class BaseButtonBuilder implements CanExport
{
    protected BaseButtonConfig $config;

    /**
     * Add JS subscriptions to the button
     * @param  array<string, string>  $subscriptions
     * @return BaseButtonBuilder
     */
    public function addSubscriptions(array $subscriptions): static
    {
        $this->config->setSubscriptions($subscriptions);
        return $this;
    }

    public function withAttrs(string $attrs): static
    {
        $this->config->setAttrs($attrs);
        return $this;
    }

    public function withText(string $text): static
    {
        $this->config->setText($text);
        return $this;
    }

    public function withIcon(string $icon): static
    {
        $this->config->setIcon($icon);
        return $this;
    }

    public function withTooltip(string $tooltip): static
    {
        $this->config->setTooltip($tooltip);
        return  $this;
    }

    public function withClass(string $class): static
    {
        $this->config->setClass($class);
        return $this;
    }

    /**
     * @param  callable|array<mixed> $condition
     * @return static
     */
    public function disableWhen(callable|array $condition): static
    {
        $builder = new ConditionBuilder();
        if (is_callable($condition)) {
            $condition($builder);
        } else {
            $builder->singleCondition($condition);
        }

        $this->config->setDisableConditions(
            $builder->export()->getConditions()
        );

        return $this;
    }

    public function export(): BaseButtonConfig
    {
        return $this->config;
    }
}
