<?php

namespace Zhelyazko777\Tables\Tests\Builders\Abstractions;

use Zhelyazko777\Tables\Builders\Abstractions\BaseButtonBuilder;
use Zhelyazko777\Tables\Builders\ConditionBuilder;
use Zhelyazko777\Tables\Tests\TestCase;

abstract class BaseButtonBuilderTest extends TestCase
{
    protected BaseButtonBuilder $builder;

    public function test_add_subscription_should_set_subscriptions_to_config()
    {
        $subscriptions = ['click' => 'onTestClick'];

        $this->builder->addSubscriptions($subscriptions);

        $this->assertEquals($subscriptions, $this->builder->export()->getSubscriptions());
    }

    public function test_with_attrs_should_set_attrs_to_config()
    {
        $attrs = ['data-test' => 'test'];

        $this->builder->withAttrs($attrs);

        $this->assertEquals($attrs, $this->builder->export()->getAttrs());
    }

    public function test_with_text_should_set_text_to_config()
    {
        $text = 'test';

        $this->builder->withText($text);

        $this->assertEquals($text, $this->builder->export()->getText());
    }

    public function test_with_icon_should_set_icon_to_config()
    {
        $icon = 'fa fa-test';

        $this->builder->withIcon($icon);

        $this->assertEquals($icon, $this->builder->export()->getIcon());
    }

    public function test_with_tooltip_should_set_tooltip_to_config()
    {
        $tooltip = 'test';

        $this->builder->withTooltip($tooltip);

        $this->assertEquals($tooltip, $this->builder->export()->getTooltip());
    }

    public function test_with_class_should_set_class_to_config()
    {
        $class = 'test';

        $this->builder->withClass($class);

        $this->assertEquals($class, $this->builder->export()->getClass());
    }

    public function test_disable_when_callback_should_add_single_disable_conditions()
    {
        $condition = ['a', '==', 'b'];

        $this->builder->disableWhen(fn (ConditionBuilder  $b) => $b->setAnd($condition));

        $this->assertEquals($condition, $this->builder->export()->getDisableConditions()['and'][0]);
    }

    public function test_disable_when_called_multiple_times_should_add_multiple_disable_conditions()
    {
        $condition = ['a', '==', 'b'];
        $secondCondition = ['c', '==', 'd'];

        $this->builder
            ->disableWhen(fn (ConditionBuilder  $b) => $b->setAnd($condition))
            ->disableWhen(fn (ConditionBuilder  $b) => $b->setAnd($secondCondition));

        $this->assertEquals($condition, $this->builder->export()->getDisableConditions()['and'][0]);
        $this->assertEquals($secondCondition, $this->builder->export()->getDisableConditions()['and'][1]);
    }
}