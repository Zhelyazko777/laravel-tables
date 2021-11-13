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

        $table = (new TableResolver)->resolve($config);

        $this->assertEquals($noItemsMsg, $table->getNoItemsMessage());
    }

    public function test_resolve_should_fetch_correct_results_from_db()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $rows = (new TableResolver)->resolve($config)->getRows();

        $this->assertCount(5, $rows);
        $this->assertEquals('Max', current(array_filter($rows, fn ($r) => $r->id === 1))->{'pets.name'});
        $this->assertEquals('Richard', current(array_filter($rows, fn ($r) => $r->id === 2))->{'pets.name'});
        $this->assertEquals('Vivi', current(array_filter($rows, fn ($r) => $r->id === 3))->{'pets.name'});
        $this->assertEquals('Mani', current(array_filter($rows, fn ($r) => $r->id === 4))->{'pets.name'});
        $this->assertEquals('Bob', current(array_filter($rows, fn ($r) => $r->id === 5))->{'pets.name'});
    }

    public function test_resolve_with_fiter_should_fetch_correct_results()
    {
        $config = $this
            ->getBasicBuilder()
            ->filter('pets.name != :name', ['name' => 'Bob'])
            ->export();

        $rows = (new TableResolver)->resolve($config)->getRows();

        $this->assertCount(4, $rows);
        $this->assertEquals('Max', current(array_filter($rows, fn ($r) => $r->id === 1))->{'pets.name'});
        $this->assertEquals('Richard', current(array_filter($rows, fn ($r) => $r->id === 2))->{'pets.name'});
        $this->assertEquals('Vivi', current(array_filter($rows, fn ($r) => $r->id === 3))->{'pets.name'});
        $this->assertEquals('Mani', current(array_filter($rows, fn ($r) => $r->id === 4))->{'pets.name'});
    }

    public function test_resolve_with_join_should_fetch_correct_results()
    {
        $config = $this
            ->getBasicBuilder()
            ->selectColumn(fn (ColumnBuilder $b) => $b->select('pet_types.name')->showAs('Type'))
            ->addJoin('pet_types', 'pets.pet_type_id', '=', 'pet_types.id')
            ->export();

        $rows = (new TableResolver)->resolve($config)->getRows();

        $this->assertCount(5, $rows);
        $this->assertEquals('Dog', current(array_filter($rows, fn ($r) => $r->id === 1))->{'pet_types.name'});
        $this->assertEquals('Dog', current(array_filter($rows, fn ($r) => $r->id === 2))->{'pet_types.name'});
        $this->assertEquals('Mouse', current(array_filter($rows, fn ($r) => $r->id === 3))->{'pet_types.name'});
        $this->assertEquals('Cat', current(array_filter($rows, fn ($r) => $r->id === 4))->{'pet_types.name'});
        $this->assertEquals('Cat', current(array_filter($rows, fn ($r) => $r->id === 5))->{'pet_types.name'});
    }

    public function test_resolve_with_left_join_should_fetch_correct_results()
    {
        $config = $this
            ->getBasicBuilder()
            ->selectColumn(fn (ColumnBuilder $b) => $b->select('toys.name')->showAs('Toy'))
            ->addLeftJoin('toys', 'pets.id', '=', 'toys.pet_id')
            ->export();

        $rows = (new TableResolver)->resolve($config)->getRows();

        $this->assertCount(5, $rows);
        $this->assertEquals('Ball 1', current(array_filter($rows, fn ($r) => $r->id === 1))->{'toys.name'});
        $this->assertEquals('Ball 2', current(array_filter($rows, fn ($r) => $r->id === 2))->{'toys.name'});
        $this->assertEquals('Ball 3', current(array_filter($rows, fn ($r) => $r->id === 3))->{'toys.name'});
        $this->assertEquals(null, current(array_filter($rows, fn ($r) => $r->id === 4))->{'toys.name'});
        $this->assertEquals(null, current(array_filter($rows, fn ($r) => $r->id === 5))->{'toys.name'});
    }

    public function test_resolve_with_order_by_should_return_correct_results()
    {
        $config = $this
            ->getBasicBuilder()
            ->orderBy('pets.name ASC')
            ->export();

        $rows = (new TableResolver)->resolve($config)->getRows();

        $this->assertEquals('Bob', $rows[0]->{'pets.name'});
        $this->assertEquals('Mani', $rows[1]->{'pets.name'});
        $this->assertEquals('Max', $rows[2]->{'pets.name'});
        $this->assertEquals('Richard', $rows[3]->{'pets.name'});
        $this->assertEquals('Vivi', $rows[4]->{'pets.name'});
    }

    public function test_resolve_with_paging_should_return_correct_results()
    {
        $config = $this
            ->getBasicBuilder()
            ->paginate(1)
            ->export();

        $paginator = (new TableResolver)->resolve($config)->getPaginator();

        $this->assertCount(1, $paginator->items());
        $this->assertEquals(5, $paginator->total());
    }

    public function test_resolve_with_including_sopft_deleted_items_should_return_correct_results()
    {
        $config = $this
            ->getBasicBuilder()
            ->includeTrashed(['pets'])
            ->export();

        $rows = (new TableResolver)->resolve($config)->getRows();

        $this->assertCount(6, $rows);
    }

    public function test_resolve_should_make_table_expandable_if_method_called()
    {
        $config = $this
            ->getBasicBuilder()
            ->makeExpandable()
            ->export();

        $table = (new TableResolver)->resolve($config);

        $this->assertTrue($table->getIsExpandable());
    }

    public function test_resolve_should_add_correct_column_ui_titles()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $table = (new TableResolver)->resolve($config);

        $this->assertEquals('Name', $table->getColumns()[0]->getUiName());
    }

    public function test_resolve_should_add_correct_column_name()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $table = (new TableResolver)->resolve($config);

        $this->assertEquals('pets.name', $table->getColumns()[0]->getName());
    }

    public function test_resolve_should_add_alias_as_column_name_when_alias_provided()
    {
        $alias = 'age_in_test';
        $config = $this
            ->getBasicBuilder()
            ->selectColumn(fn (ColumnBuilder $b) => $b->select('age')->useAs($alias))
            ->export();

        $table = (new TableResolver)->resolve($config);

        $this->assertEquals($alias, $table->getColumns()[1]->getName());
    }

    public function test_resolve_should_add_link_button_correctly()
    {
        $config = $this
            ->getBasicBuilder()
            ->export();

        $table = (new TableResolver)->resolve($config);

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

        $table = (new TableResolver)->resolve($config);

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

        $table = (new TableResolver)->resolve($config);

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
        $resolver = new TableResolver;

        $resolver->resolve($config);
    }

    private function getBasicBuilder(): TableBuilder
    {
        return (new TableBuilder())
            ->fromDbTable('pets')
            ->selectColumn(fn (ColumnBuilder $c) => $c->select('pets.name')->showAs('Name'))
            ->addTextButton(fn (TextButtonBuilder $b) => $b)
            ->addLinkButton(fn (LinkButtonBuilder $b) => $b)
            ->addModalButton(fn (ModalButtonBuilder $b) => $b);
    }
}