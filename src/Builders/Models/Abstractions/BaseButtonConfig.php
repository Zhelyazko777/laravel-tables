<?php

namespace Zhelyazko777\Tables\Builders\Models\Abstractions;

use Zhelyazko777\Tables\Builders\Models\ConditionConfig;
use ReflectionClass;
use Zhelyazko777\Utilities\Exportable;

class BaseButtonConfig implements \JsonSerializable
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

    private string $attrs = '';

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
     * @return BaseButtonConfig
     */
    public function setSubscriptions(array $subscriptions): BaseButtonConfig
    {
        $this->subscriptions = $subscriptions;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttrs(): string
    {
        return $this->attrs;
    }

    /**
     * @param  string  $attrs
     * @return BaseButtonConfig
     */
    public function setAttrs(string $attrs): BaseButtonConfig
    {
        $this->attrs = $attrs;
        return $this;
    }

    public function getType(): string
    {
        return lcfirst(str_replace('ButtonConfig', '', (new ReflectionClass($this))->getShortName()));
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
     * @return BaseButtonConfig
     */
    public function setDisableConditions(array $disableConditions): BaseButtonConfig
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
     * @return BaseButtonConfig
     */
    public function setText(string $text): BaseButtonConfig
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
     * @return BaseButtonConfig
     */
    public function setIcon(string $icon): BaseButtonConfig
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
     * @return BaseButtonConfig
     */
    public function setTooltip(string $tooltip): BaseButtonConfig
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
     * @return BaseButtonConfig
     */
    public function setClass(string $class): BaseButtonConfig
    {
        $this->class = $class;
        return $this;
    }
}
