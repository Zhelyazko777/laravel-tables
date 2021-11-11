<?php

namespace Zhelyazko777\Tables\Builders;

use Zhelyazko777\Utilities\Contracts\CanExport;
use Zhelyazko777\Tables\Builders\Models\SelectColumnConfig;

class ColumnBuilder implements CanExport
{
    private SelectColumnConfig $config;

    public function __construct()
    {
        $this->config = new SelectColumnConfig();
    }

    public function select(string $column): self
    {
        $this->config->setName($column);
        return $this;
    }

    public function showAs(string $name): self
    {
        $this->config->setUiName($name);
        return $this;
    }

    public function useAs(string $alias): self
    {
        $this->config->setAlias($alias);
        return $this;
    }

    public function excludeFromTable(): self
    {
        $this->config->setIsHidden(true);
        return $this;
    }

    public function hideOnMobile(): self
    {
        $this->config->setIsHiddenOnMobile(true);
        return $this;
    }

    public function hideOnDesktop(): self
    {
        $this->config->setIsHiddenOnDesktop(true);
        return $this;
    }

    public function makePhoneLink(): self
    {
        $this->config->setIsPhone(true);
        return $this;
    }

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

    public function formatAsDate(): self
    {
        $column = $this->config->getName();
        $this->config->setName("DATE_FORMAT($column, '%d-%m-%Y')");
        return $this;
    }

    public function export(): SelectColumnConfig
    {
        return $this->config;
    }
}
