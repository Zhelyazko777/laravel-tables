<?php

namespace Zhelyazko777\Tables\Builders;

use Zhelyazko777\Utilities\Contracts\CanExport;
use Zhelyazko777\Tables\Builders\Models\ColumnConfig;

class ColumnBuilder implements CanExport
{
    private ColumnConfig $config;

    public function __construct()
    {
        $this->config = new ColumnConfig();
    }

    /**
     * Selects specific column
     * @param  string  $column
     * @return $this
     */
    public function select(string $column): self
    {
        $this->config->setName($column);
        return $this;
    }

    /**
     * Sets the UI table column title
     * @param  string  $name
     * @return $this
     */
    public function showAs(string $name): self
    {
        $this->config->setUiName($name);
        return $this;
    }

    /**
     * Sets an alias for easier usage in the conditions for example
     * @param  string  $alias
     * @return $this
     */
    public function useAs(string $alias): self
    {
        $this->config->setAlias($alias);
        return $this;
    }

    /**
     * Fetches the column, but doesnt include it in the UI table
     * @return $this
     */
    public function excludeFromTable(): self
    {
        $this->config->setIsHidden(true);
        return $this;
    }

    /**
     * Hides the column on mobile devices
     * @return $this
     */
    public function hideOnMobile(): self
    {
        $this->config->setIsHiddenOnMobile(true);
        return $this;
    }

    /**
     * Hides the column on desktop devices
     * @return $this
     */
    public function hideOnDesktop(): self
    {
        $this->config->setIsHiddenOnDesktop(true);
        return $this;
    }

    /**
     * Shows the column values like a clickable link
     * which can call directly the number by click
     * (adds "tel:" in the href)
     * @return $this
     */
    public function makePhoneLink(): self
    {
        $this->config->setIsPhone(true);
        return $this;
    }

    /**
     * Renders the column values as links
     * @param  string  $route
     * @param  callable|null  $disableCondition
     * @return $this
     */
    public function onClickGoTo(string $route, ?callable $disableCondition = null): self
    {
        $this->config->setRoute($route);

        if (!is_null($disableCondition)) {
            $builder = new ConditionBuilder();
            $disableCondition($builder);
            $this->config->setClickableConditions(
                $builder->export()->getConditions(),
            );
        }

        return $this;
    }

    /**
     * Adds tooltip for the column values
     * @param  string  $text
     * @param  bool  $showIcon
     * @param  callable|array<string|null>|null  $removeCondition
     * @return $this
     */
    public function addTooltip(string $text, bool $showIcon = true, callable|array $removeCondition = null): self
    {
        $this->config->setTooltip($text);
        $this->config->setShowTooltipIcon($showIcon);

        if (!is_null($removeCondition)) {
            $builder = new ConditionBuilder();

            if (is_callable($removeCondition)) {
                $removeCondition($builder);
            } else {
                $builder->singleCondition($removeCondition);
            }

            $this->config->setRemoveTooltipConditions(
                $builder->export()->getConditions(),
            );
        }

        return $this;
    }

    /**
     * Formats the column value as date
     * @return $this
     */
    public function formatAsDate(): self
    {
        $column = $this->config->getName();
        $this->config->setName("DATE_FORMAT($column, '%d-%m-%Y')");
        return $this;
    }

    /**
     * Adds suffix to the table column value
     * @param  string  $suffix
     * @return $this
     */
    public function withSuffix(string $suffix): self
    {
        $this->config->setSuffix($suffix);
        return $this;
    }

    /**
     * Adds prefix to the table column value
     * @param  string  $prefix
     * @return $this
     */
    public function withPrefix(string $prefix): self
    {
        $this->config->setPrefix($prefix);
        return $this;
    }

    /**
     * Exports the config
     * @return ColumnConfig
     */
    public function export(): ColumnConfig
    {
        return $this->config;
    }
}
