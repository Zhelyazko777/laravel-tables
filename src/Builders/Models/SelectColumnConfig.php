<?php

namespace Zhelyazko777\Tables\Builders\Models;

use Zhelyazko777\Utilities\Exportable;

class SelectColumnConfig implements \JsonSerializable
{
    use Exportable;

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

    /**
     * @return string
     */
    public function getUiName(): string
    {
        return $this->uiName;
    }

    /**
     * @param  string  $uiName
     * @return SelectColumnConfig
     */
    public function setUiName(string $uiName): SelectColumnConfig
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
     * @param  string  $tooltip
     * @return SelectColumnConfig
     */
    public function setTooltip(string $tooltip): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setShowTooltipIcon(bool $showTooltipIcon): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setRemoveTooltipConditions(array $removeTooltipConditions): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setClickableConditions(array $clickableConditions): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setName(string $name): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setAlias(?string $alias): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setIsHidden(bool $isHidden): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setIsHiddenOnMobile(bool $isHiddenOnMobile): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setIsHiddenOnDesktop(bool $isHiddenOnDesktop): SelectColumnConfig
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
     * @return SelectColumnConfig
     */
    public function setIsPhone(bool $isPhone): SelectColumnConfig
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
     * @param  string  $route
     * @return SelectColumnConfig
     */
    public function setRoute(string $route): SelectColumnConfig
    {
        $this->route = $route;
        return $this;
    }
}
