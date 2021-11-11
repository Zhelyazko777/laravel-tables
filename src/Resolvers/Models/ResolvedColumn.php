<?php

namespace Zhelyazko777\Tables\Resolvers\Models;

use Zhelyazko777\Utilities\Exportable;

class ResolvedColumn implements \JsonSerializable
{
    use Exportable;

    private string $name = '';

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
     * @return self
     */
    public function setUiName(string $uiName): self
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
     * @return self
     */
    public function setTooltip(?string $tooltip): self
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
     * @return self
     */
    public function setShowTooltipIcon(bool $showTooltipIcon): self
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
     * @return self
     */
    public function setRemoveTooltipConditions(array $removeTooltipConditions): self
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
     * @return self
     */
    public function setClickableConditions(array $clickableConditions): self
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
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
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
     * @return self
     */
    public function setIsHidden(bool $isHidden): self
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
     * @return self
     */
    public function setIsHiddenOnMobile(bool $isHiddenOnMobile): self
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
     * @return self
     */
    public function setIsHiddenOnDesktop(bool $isHiddenOnDesktop): self
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
     * @return self
     */
    public function setIsPhone(bool $isPhone): self
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
     * @return self
     */
    public function setRoute(?string $route): self
    {
        $this->route = $route;
        return $this;
    }
}