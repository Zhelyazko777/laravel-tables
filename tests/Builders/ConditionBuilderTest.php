<?php

namespace Zhelyazko777\Tables\Tests\Builders;

use Zhelyazko777\Tables\Builders\ConditionBuilder;
use Zhelyazko777\Tables\Builders\Models\ConditionConfig;
use Zhelyazko777\Tables\Tests\TestCase;

class ConditionBuilderTest extends TestCase
{
    public function test_export_should_return_condition_config_instance()
    {
        $builder = new ConditionBuilder();

        $configInstance = $builder->export();

        $this->assertEquals(ConditionConfig::class, get_class($configInstance));
    }

    public function test_single_condition_should_add_and_condition_to_config()
    {
        $builder = new ConditionBuilder();
        $condition = ['a', '==', 'b'];

        $builder->singleCondition($condition);

        $this->assertCount(1, $builder->export()->getConditions()['and']);
        $this->assertEquals($condition, $builder->export()->getConditions()['and'][0]);
    }

    public function test_single_condition_called_multiple_times_should_add_only_one_condition_to_config()
    {
        $builder = new ConditionBuilder();
        $condition = ['a', '==', 'b'];
        $secondCondition = ['c', '==', 'd'];

        $builder->singleCondition($condition)->singleCondition($secondCondition);

        $this->assertCount(1, $builder->export()->getConditions()['and']);
        $this->assertEquals($secondCondition, $builder->export()->getConditions()['and'][0]);
    }

    public function test_set_and_should_add_and_condition_to_config()
    {
        $builder = new ConditionBuilder();
        $condition = [ 'a', '==', 'b' ];

        $builder->setAnd($condition);

        $this->assertEquals($condition, $builder->export()->getConditions()['and'][0]);
    }

    public function test_set_and_called_multiple_times_should_add_both_and_conditions_to_config()
    {
        $builder = new ConditionBuilder();
        $condition = [ 'a', '==', 'b' ];
        $secondCondition = [ 'c', '==', 'd' ];

        $builder->setAnd($condition)->setAnd($secondCondition);

        $this->assertEquals($condition, $builder->export()->getConditions()['and'][0]);
        $this->assertEquals($secondCondition, $builder->export()->getConditions()['and'][1]);
    }

    public function test_set_and_with_array_of_rules_should_add_both_and_conditions_to_config()
    {
        $builder = new ConditionBuilder();
        $condition = [ 'a', '==', 'b' ];
        $secondCondition = [ 'c', '==', 'd' ];

        $builder->setAnd([$condition, $secondCondition]);

        $this->assertEquals($condition, $builder->export()->getConditions()['and'][0]);
        $this->assertEquals($secondCondition, $builder->export()->getConditions()['and'][1]);
    }

    public function test_set_and_with_nested_rule_should_nest_array_with_the_rule_in_the_config()
    {
        $builder = new ConditionBuilder();
        $condition = [ 'a', '==', 'b' ];
        $nestedRule = ['c', '>', 'd'];

        $builder->setAnd(
            $condition,
            fn (ConditionBuilder $c) => $c->setOr($nestedRule)
        );

        $this->assertEquals(['or' => [$nestedRule]], $builder->export()->getConditions()['and'][1]);
    }

    public function test_set_or_should_add_and_condition_to_config()
    {
        $builder = new ConditionBuilder();
        $condition = [ 'a', '==', 'b' ];

        $builder->setOr($condition);

        $this->assertEquals($condition, $builder->export()->getConditions()['or'][0]);
    }

    public function test_set_or_called_multiple_times_should_add_both_and_conditions_to_config()
    {
        $builder = new ConditionBuilder();
        $condition = [ 'a', '==', 'b' ];
        $secondCondition = [ 'c', '==', 'd' ];

        $builder->setOr($condition)->setOr($secondCondition);

        $this->assertEquals($condition, $builder->export()->getConditions()['or'][0]);
        $this->assertEquals($secondCondition, $builder->export()->getConditions()['or'][1]);
    }

    public function test_set_or_with_array_of_rules_should_add_both_and_conditions_to_config()
    {
        $builder = new ConditionBuilder();
        $condition = [ 'a', '==', 'b' ];
        $secondCondition = [ 'c', '==', 'd' ];

        $builder->setOr([$condition, $secondCondition]);

        $this->assertEquals($condition, $builder->export()->getConditions()['or'][0]);
        $this->assertEquals($secondCondition, $builder->export()->getConditions()['or'][1]);
    }

    public function test_set_or_with_nested_rule_should_nest_array_with_the_rule_in_the_config()
    {
        $builder = new ConditionBuilder();
        $condition = [ 'a', '==', 'b' ];
        $nestedRule = ['c', '>', 'd'];

        $builder->setOr(
            $condition,
            fn (ConditionBuilder $c) => $c->setAnd($nestedRule)
        );

        $this->assertEquals(['and' => [$nestedRule]], $builder->export()->getConditions()['or'][1]);
    }
}