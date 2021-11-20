<?php

namespace Zhelyazko777\Tables\Tests\Builders;

use Zhelyazko777\Tables\Builders\ColumnBuilder;
use Zhelyazko777\Tables\Builders\ConditionBuilder;
use Zhelyazko777\Tables\Builders\Models\ColumnConfig;
use Zhelyazko777\Tables\Tests\TestCase;

class ColumnBuilderTest extends TestCase
{
    public function test_export_should_return_column_config_instance_to_config()
    {
        $builder = new ColumnBuilder();

        $configInstance = $builder->export();

        $this->assertEquals(ColumnConfig::class, get_class($configInstance));
    }

    public function test_select_should_set_config_name_to_config()
    {
        $builder = new ColumnBuilder();
        $selectedColumn = 'test_field';

        $builder->select($selectedColumn);

        $this->assertEquals($selectedColumn, $builder->export()->getName());
    }

    public function test_show_as_should_set_ui_name_to_config()
    {
        $builder = new ColumnBuilder();
        $uiName = 'Some Test Title';

        $builder->showAs($uiName);

        $this->assertEquals($uiName, $builder->export()->getUiName());
    }

    public function test_use_as_should_set_alias_to_config()
    {
        $builder = new ColumnBuilder();
        $alias = 'testAlias';

        $builder->useAs($alias);

        $this->assertEquals($alias, $builder->export()->getAlias());
    }

    public function test_exclude_from_table_should_set_is_hidden_to_true_in_config()
    {
        $builder = new ColumnBuilder();

        $builder->excludeFromTable();

        $this->assertTrue($builder->export()->getIsHidden());
    }

    public function test_hide_on_mobile_should_set_is_hidden_on_mobile_to_true_in_config()
    {
        $builder = new ColumnBuilder();

        $builder->hideOnMobile();

        $this->assertTrue($builder->export()->getIsHiddenOnMobile());
    }

    public function test_exclude_from_table_should_set_is_hidden_on_desktop_to_true_in_config()
    {
        $builder = new ColumnBuilder();

        $builder->hideOnDesktop();

        $this->assertTrue($builder->export()->getIsHiddenOnDesktop());
    }

    public function test_make_phone_link_should_set_is_phone_to_true_in_config()
    {
        $builder = new ColumnBuilder();

        $builder->makePhoneLink();

        $this->assertTrue($builder->export()->getIsPhone());
    }

    public function test_on_click_go_to_should_add_route_to_config()
    {
        $builder = new ColumnBuilder();
        $route = '/test';

        $builder->onClickGoTo($route);

        $this->assertEquals($builder->export()->getRoute(), $route);
    }

    public function test_on_click_go_to_should_add_disable_condition_to_config()
    {
        $builder = new ColumnBuilder();
        $route = '/test';

        $builder->onClickGoTo($route, fn (ConditionBuilder $c) => $c->setAnd([ 'a', '==', 'b' ]));

        $this->assertGreaterThan(0, count($builder->export()->getClickableConditions()));
    }

    public function test_add_tooltip_should_add_tooltip_to_config()
    {
        $builder = new ColumnBuilder();
        $tooltipText = 'test tooltip';

        $builder->addTooltip($tooltipText);

        $this->assertEquals($builder->export()->getTooltip(), $tooltipText);
    }

    public function test_add_tooltip_with_show_icon_false_should_set_show_tooltip_icon_to_config()
    {
        $builder = new ColumnBuilder();

        $builder->addTooltip('test tooltip', false);

        $this->assertFalse($builder->export()->getShowTooltipIcon());
    }

    public function test_add_tooltip_without_passing_show_icon_should_set_show_tooltip_icon_to_true_in_config()
    {
        $builder = new ColumnBuilder();

        $builder->addTooltip('test tooltip');

        $this->assertTrue($builder->export()->getShowTooltipIcon());
    }

    public function test_add_tooltip_without_passing_condition_builder_wont_add_remove_tooltip_condition_to_config()
    {
        $builder = new ColumnBuilder();

        $builder->addTooltip('test tooltip');

        $this->assertCount(0, $builder->export()->getRemoveTooltipConditions());
    }

    public function test_add_tooltip_with_condition_builder_should_add_remove_tooltip_condition_to_config()
    {
        $builder = new ColumnBuilder();

        $builder
            ->addTooltip(
                'test tooltip',
                true,
                fn (ConditionBuilder $c) => $c->setAnd(['a', '==', ''])
            );

        $this->assertCount(1, $builder->export()->getRemoveTooltipConditions());
    }

    public function test_format_as_date_should_surround_column_name_with_mysql_date_format()
    {
        $builder = new ColumnBuilder();
        $columnName = 'test_column';

        $builder->select($columnName)->formatAsDate();

        $this->assertEquals("DATE_FORMAT($columnName, '%d-%m-%Y')", $builder->export()->getName());
    }

    public function test_with_suffix_should_add_sufix_to_column()
    {
        $suffix = '%';
        $builder = new ColumnBuilder();

        $builder->withSuffix($suffix);

        $this->assertEquals($suffix, $builder->export()->getSuffix());
    }

    public function test_with_prefix_should_add_sufix_to_column()
    {
        $prefix = '%';
        $builder = new ColumnBuilder();

        $builder->withPrefix($prefix);

        $this->assertEquals($prefix, $builder->export()->getPrefix());
    }
}