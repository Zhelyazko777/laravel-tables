<?php

namespace Zhelyazko777\Tables\Tests\Builders;

use Zhelyazko777\Tables\Builders\ColumnBuilder;
use Zhelyazko777\Tables\Builders\LinkButtonBuilder;
use Zhelyazko777\Tables\Builders\ModalButtonBuilder;
use Zhelyazko777\Tables\Builders\Models\InnerJoin;
use Zhelyazko777\Tables\Builders\Models\LeftJoin;
use Zhelyazko777\Tables\Builders\Models\LinkButtonConfig;
use Zhelyazko777\Tables\Builders\Models\ModalButtonConfig;
use Zhelyazko777\Tables\Builders\Models\TableConfig;
use Zhelyazko777\Tables\Builders\Models\TextButtonConfig;
use Zhelyazko777\Tables\Builders\TableBuilder;
use Zhelyazko777\Tables\Builders\TextButtonBuilder;
use Zhelyazko777\Tables\Tests\TestCase;

class TableBuilderTest extends TestCase
{
    public function test_export_returns_table_config()
    {
        $builder = new TableBuilder();

        $builderInstance = $builder->export();

        $this->assertEquals(TableConfig::class, get_class($builderInstance));
    }

    public function test_from_db_table_should_add_main_table_to_config()
    {
        $builder = new TableBuilder();
        $tableName = 'test_table';

        $builder->fromDbTable($tableName);

        $this->assertEquals($tableName, $builder->export()->getMainTable());
    }

    public function test_add_modal_button_should_add_btn_of_type_modal_button_config()
    {
        $builder = new TableBuilder();

        $builder->addModalButton(fn (ModalButtonBuilder $b) => $b);

        $rowBtns = $builder->export()->getButtons();
        $this->assertCount(1, $rowBtns);
        $this->assertEquals(ModalButtonConfig::class, get_class($rowBtns[0]));
    }

    public function test_add_link_button_should_add_btn_of_type_link_button_config()
    {
        $builder = new TableBuilder();

        $builder->addLinkButton(fn (LinkButtonBuilder $b) => $b);

        $rowBtns = $builder->export()->getButtons();
        $this->assertCount(1, $rowBtns);
        $this->assertEquals(LinkButtonConfig::class, get_class($rowBtns[0]));
    }

    public function test_add_text_button_should_add_btn_of_type_text_button_config()
    {
        $builder = new TableBuilder();

        $builder->addTextButton(fn (TextButtonBuilder $b) => $b);

        $rowBtns = $builder->export()->getButtons();
        $this->assertCount(1, $rowBtns);
        $this->assertEquals(TextButtonConfig::class, get_class($rowBtns[0]));
    }

    public function test_add_select_column_should_add_new_column_to_config()
    {
        $builder = new TableBuilder();

        $builder->selectColumn(fn (ColumnBuilder $b) => $b);

        $this->assertEquals(1, count($builder->export()->getColumns()));
    }

    public function test_add_join_should_add_join_with_type_inner_join_to_config()
    {
        $builder = new TableBuilder();

        $builder->addJoin('first', 'first.id', '==', 'second.first_id');

        $joins = $builder->export()->getJoins();
        $this->assertCount(1, $joins);
        $this->assertEquals(InnerJoin::class, get_class($joins[0]));
    }

    public function test_add_left_join_should_add_join_with_type_left_join_to_config()
    {
        $builder = new TableBuilder();

        $builder->addLeftJoin('first', 'first.id', '==', 'second.first_id');

        $joins = $builder->export()->getJoins();
        $this->assertCount(1, $joins);
        $this->assertEquals(LeftJoin::class, get_class($joins[0]));
    }

    public function test_order_by_should_order_by_to_config()
    {
        $builder = new TableBuilder();
        $orderColumn = 'test_column';

        $builder->orderBy($orderColumn);

        $this->assertEquals($orderColumn, $builder->export()->getOrderBy());
    }

    public function test_order_by_with_bindings_should_add_order_by_bindings_to_config()
    {
        $builder = new TableBuilder();
        $orderColumn = 'test_column';
        $bindings = ['testBinding' => 'test'];

        $builder->orderBy($orderColumn, $bindings);

        $existingBindings = $builder->export()->getOrderByBindings();
        $this->assertCount(1, $bindings);
        $this->assertEquals($bindings, $existingBindings);
    }

    public function test_order_by_without_bindings_should_not_add_order_by_bindings_to_config()
    {
        $builder = new TableBuilder();
        $orderColumn = 'test_column';

        $builder->orderBy($orderColumn);

        $this->assertCount(0, $builder->export()->getOrderByBindings());
    }

    public function test_make_expandable_should_add_is_expandable_true_to_config()
    {
        $builder = new TableBuilder();

        $builder->makeExpandable();

        $this->assertEquals(true, $builder->export()->getIsExpandable());
    }

    public function test_if_no_data_show_should_add_no_items_msg_to_config()
    {
        $builder = new TableBuilder();
        $message = 'Some test no items message';

        $builder->ifNoDataShow($message);

        $this->assertEquals($message, $builder->export()->getNoItemsMessage());
    }

    public function test_paginate_should_set_items_per_page_to_config()
    {
        $builder = new TableBuilder();
        $numberOfItems = 20;

        $builder->paginate($numberOfItems);

        $this->assertEquals($numberOfItems, $builder->export()->getItemsPerPage());
    }

    public function test_filter_should_add_where_expression_to_config()
    {
        $builder = new TableBuilder();
        $filter = 'a = b';

        $builder->filter($filter);

        $this->assertEquals($filter, $builder->export()->getWhereExpression());
    }

    public function test_filter_without_bindings_should_not_add_where_bindings_to_config()
    {
        $builder = new TableBuilder();
        $filter = 'a = b';

        $builder->filter($filter);

        $this->assertCount(0, $builder->export()->getWhereBindings());
    }

    public function test_filter_with_bindings_should_add_where_bindings_to_config()
    {
        $builder = new TableBuilder();
        $filter = 'a = :b';
        $bindings = [ 'b' => 'Some test value' ];

        $builder->filter($filter, $bindings);

        $this->assertEquals($bindings, $builder->export()->getWhereBindings());
    }

    public function test_include_trashed_should_add_included_trashed_tables()
    {
        $builder = new TableBuilder();
        $trashedTables = ['test_trashed_table'];

        $builder->includeTrashed($trashedTables);

        $this->assertEquals($trashedTables, $builder->export()->getIncludedTrashedTables());
    }
}