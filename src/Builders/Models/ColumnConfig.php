<?php

namespace Zhelyazko777\Tables\Builders\Models;

use Zhelyazko777\Utilities\Exportable;

class ColumnConfig
{
    private string $name = '';

    private ?string $alias = null;

    private string $uiName = '';

    private bool $isHidden = false;

    private bool $isHiddenOnMobile = false;

    private bool $isHiddenOnDesktop = false;

    private bool $isPhone = false;

    private ?string $route = null;

    /**
     * @var array<string, mixed>
     */
    private array $clickableConditions = [];

    /**
     * @var array<string, mixed>
     */
    private array $removeTooltipConditions = [];

    private ?string $tooltip = null;

    private bool $showTooltipIcon = false;

    private ?string $suffix = null;

    private ?string $prefix = null;

    /**
     * @return string|null
     */
    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    /**
     * @param  string|null  $suffix
     * @return static
     */
    public function setSuffix(?string $suffix): static
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * @param  string|null  $prefix
     * @return static
     */
    public function setPrefix(?string $prefix): static
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getUiName(): string
    {
        return $this->uiName;
    }

    /**
     * @param  string  $uiName
     * @return ColumnConfig
     */
    public function setUiName(string $uiName): ColumnConfig
    {
        $this->uiName = $uiName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTooltip(): ?string
    {
        return $this->tooltip;
    }

    /**
     * @param  string|null  $tooltip
     * @return ColumnConfig
     */
    public function setTooltip(?string $tooltip): ColumnConfig
    {
        $this->tooltip = $tooltip;
        return $this;
    }

    /**
     * @return bool
     */
    public function getShowTooltipIcon(): bool
    {
        return $this->showTooltipIcon;
    }

    /**
     * @param  bool  $showTooltipIcon
     * @return ColumnConfig
     */
    public function setShowTooltipIcon(bool $showTooltipIcon): ColumnConfig
    {
        $this->showTooltipIcon = $showTooltipIcon;
        return $this;
    }


    /**
     * @return array<string, mixed>
     */
    public function getRemoveTooltipConditions(): array
    {
        return $this->removeTooltipConditions;
    }

    /**
     * @param  array<string, mixed>  $removeTooltipConditions
     * @return ColumnConfig
     */
    public function setRemoveTooltipConditions(array $removeTooltipConditions): ColumnConfig
    {
        $this->removeTooltipConditions = $removeTooltipConditions;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getClickableConditions(): array
    {
        return $this->clickableConditions;
    }

    /**
     * @param  array<string, mixed>  $clickableConditions
     * @return ColumnConfig
     */
    public function setClickableConditions(array $clickableConditions): ColumnConfig
    {
        $this->clickableConditions = $clickableConditions;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     * @return ColumnConfig
     */
    public function setName(string $name): ColumnConfig
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @param  string|null  $alias
     * @return ColumnConfig
     */
    public function setAlias(?string $alias): ColumnConfig
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsHidden(): bool
    {
        return $this->isHidden;
    }

    /**
     * @param  bool  $isHidden
     * @return ColumnConfig
     */
    public function setIsHidden(bool $isHidden): ColumnConfig
    {
        $this->isHidden = $isHidden;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsHiddenOnMobile(): bool
    {
        return $this->isHiddenOnMobile;
    }

    /**
     * @param  bool  $isHiddenOnMobile
     * @return ColumnConfig
     */
    public function setIsHiddenOnMobile(bool $isHiddenOnMobile): ColumnConfig
    {
        $this->isHiddenOnMobile = $isHiddenOnMobile;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsHiddenOnDesktop(): bool
    {
        return $this->isHiddenOnDesktop;
    }

    /**
     * @param  bool  $isHiddenOnDesktop
     * @return ColumnConfig
     */
    public function setIsHiddenOnDesktop(bool $isHiddenOnDesktop): ColumnConfig
    {
        $this->isHiddenOnDesktop = $isHiddenOnDesktop;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsPhone(): bool
    {
        return $this->isPhone;
    }

    /**
     * @param  bool  $isPhone
     * @return ColumnConfig
     */
    public function setIsPhone(bool $isPhone): ColumnConfig
    {
        $this->isPhone = $isPhone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @param  string|null  $route
     * @return ColumnConfig
     */
    public function setRoute(?string $route): ColumnConfig
    {
        $this->route = $route;
        return $this;
    }
}
