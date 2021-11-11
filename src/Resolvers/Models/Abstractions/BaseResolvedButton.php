<?php

namespace Zhelyazko777\Tables\Resolvers\Models\Abstractions;

use Zhelyazko777\Tables\Builders\Models\ConditionConfig;
use Zhelyazko777\Utilities\Exportable;

class BaseResolvedButton implements \JsonSerializable
{
    use Exportable;

    /**
     * @var array<string, mixed>
     */
    private array $disableConditions = [];

    private string $text = '';

    private string $icon = '';

    private string $tooltip = '';

    private string $class = '';

    private string $type = '';

    /**
     * HTML attributes
     * @var array<string, string>
     */
    private array $attrs = [];

    /**
     * Array with JS subscriptions which use the button as target element
     * @var array<string, string>
     */
    private array $subscriptions = [];

    /**
     * @return string[]
     */
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    /**
     * @param  string[]  $subscriptions
     * @return self
     */
    public function setSubscriptions(array $subscriptions): self
    {
        $this->subscriptions = $subscriptions;
        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getAttrs(): array
    {
        return $this->attrs;
    }

    /**
     * @param  array<string, string>  $attrs
     * @return self
     */
    public function setAttrs(array $attrs): self
    {
        $this->attrs = $attrs;
        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<ConditionConfig>
     */
    public function getDisableConditions(): array
    {
        return $this->disableConditions;
    }

    /**
     * @param  array<ConditionConfig>  $disableConditions
     * @return self
     */
    public function setDisableConditions(array $disableConditions): self
    {
        $this->disableConditions = $disableConditions;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param  string  $text
     * @return self
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param  string  $icon
     * @return self
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getTooltip(): string
    {
        return $this->tooltip;
    }

    /**
     * @param  string  $tooltip
     * @return self
     */
    public function setTooltip(string $tooltip): self
    {
        $this->tooltip = $tooltip;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param  string  $class
     * @return self
     */
    public function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }
}