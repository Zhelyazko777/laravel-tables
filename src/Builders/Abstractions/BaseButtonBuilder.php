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

    /**
     * Add HTML attributes to the button
     * @param  array<string, string>  $attrs
     * @return $this
     */
    public function withAttrs(array $attrs): static
    {
        $this->config->setAttrs($attrs);
        return $this;
    }

    /**
     * Adds text for the button
     * @param  string  $text
     * @return $this
     */
    public function withText(string $text): static
    {
        $this->config->setText($text);
        return $this;
    }

    /**
     * Adds fontawesome icon to the button
     * (You should load fontawesome before using it here)
     * @param  string  $icon
     * @return $this
     */
    public function withIcon(string $icon): static
    {
        $this->config->setIcon($icon);
        return $this;
    }

    /**
     * Adds tooltip to the button
     * @param  string  $tooltip
     * @return $this
     */
    public function withTooltip(string $tooltip): static
    {
        $this->config->setTooltip($tooltip);
        return  $this;
    }

    /**
     * Adds classes to the button
     * @param  string  $class
     * @return $this
     */
    public function withClass(string $class): static
    {
        $this->config->setClass($class);
        return $this;
    }

    /**
     * Builds disable button rules
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
            array_merge_recursive(
                $this->config->getDisableConditions(),
                $builder->export()->getConditions(),
            ),
        );

        return $this;
    }

    /**
     * Exports the config
     * @return BaseButtonConfig
     */
    public function export(): BaseButtonConfig
    {
        return $this->config;
    }
}
