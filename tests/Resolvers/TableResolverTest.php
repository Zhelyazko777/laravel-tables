<?php

namespace Zhelyazko777\Tables\Tests\Resolvers;

use Zhelyazko777\Tables\Builders\ColumnBuilder;
use Zhelyazko777\Tables\Builders\LinkButtonBuilder;
use Zhelyazko777\Tables\Builders\ModalButtonBuilder;
use Zhelyazko777\Tables\Builders\TableBuilder;
use Zhelyazko777\Tables\Builders\TextButtonBuilder;
use Zhelyazko777\Tables\Resolvers\Models\ResolvedLinkButton;
use Zhelyazko777\Tables\Resolvers\Models\ResolvedModalButton;
use Zhelyazko777\Tables\Resolvers\Models\ResolvedTextButton;
use Zhelyazko777\Tables\Resolvers\TableResolver;
use Zhelyazko777\Tables\Tests\TestCase;

class TableResolverTest extends TestCase
{
    // TODO:: Add tests about the rows fetched
    protected function setUp(): void
    {
        parent::setUp();
        $this->set_up_db();
    }

    public function test_resolve_should_add_correct_no_data_text()
    {
        $noItemsMsg = 'Test';
        $config = $this
            ->getBasicBuilder()
            ->ifNoDataShow($noItemsMsg)
            ->export();

        $table = (new TableResolver())->resolve($config);

        $this->assertEquals($noItemsMsg, $table->getNoItemsMessage());
    }

    public function test_resolve_should_make_table_expandable_if_method_called()
    {
        $config = $this
            ->getBasicBuilder()
            ->makeExpandable()
            ->export();

        $table = (new TableResolver())->resolve($config);

        $this->assertTrue($table->getIsExpandable());
    }

    public function test_resolve_should_add_correct_column_ui_titles()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $table = (new TableResolver())->resolve($config);

        $this->assertEquals('Name', $table->getColumns()[0]->getUiName());
    }

    public function test_resolve_should_add_correct_column_name()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $table = (new TableResolver())->resolve($config);

        $this->assertEquals('name', $table->getColumns()[0]->getName());
    }

    public function test_resolve_should_add_alias_as_column_name_when_alias_provided()
    {
        $alias = 'age_in_test';
        $config = $this
            ->getBasicBuilder()
            ->selectColumn(fn (ColumnBuilder $b) => $b->select('age')->useAs($alias))
            ->export();

        $table = (new TableResolver())->resolve($config);

        $this->assertEquals($alias, $table->getColumns()[1]->getName());
    }

    public function test_resolve_should_add_link_button_correctly()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $table = (new TableResolver())->resolve($config);

        $this->assertCount(
            1,
            array_filter(
                $table->getButtons(),
                fn ($b) => get_class($b) === ResolvedLinkButton::class
            ),
        );
    }


    public function test_resolve_should_add_modal_button_correctly()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $table = (new TableResolver())->resolve($config);

        $this->assertCount(
            1,
            array_filter(
                $table->getButtons(),
                fn ($b) => get_class($b) === ResolvedModalButton::class
            ),
        );
    }


    public function test_resolve_should_add_text_button_correctly()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $table = (new TableResolver())->resolve($config);

        $this->assertCount(
            1,
            array_filter(
                $table->getButtons(),
                fn ($b) => get_class($b) === ResolvedTextButton::class
            ),
        );
    }

    public function test_resolve_should_throw_exception_if_no_columns_selected()
    {
        $this->expectExceptionMessage('You should select at least on column from the table.');

        $builder = new TableBuilder();
        $config = $builder->export();
        $resolver = new TableResolver();

        $resolver->resolve($config);
    }

    private function getBasicBuilder(): TableBuilder
    {
        return (new TableBuilder())
            ->fromDbTable('pets')
            ->selectColumn(fn (ColumnBuilder $c) => $c->select('name')->showAs('Name'))
            ->addTextButton(fn (TextButtonBuilder $b) => $b)
            ->addLinkButton(fn (LinkButtonBuilder $b) => $b)
            ->addModalButton(fn (ModalButtonBuilder $b) => $b);
    }
}