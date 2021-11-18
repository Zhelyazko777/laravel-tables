<?php

namespace Zhelyazko777\Tables\Tests\Resolvers;

use Zhelyazko777\Tables\Builders\Models\ColumnConfig;
use Zhelyazko777\Tables\Builders\Models\InnerJoin;
use Zhelyazko777\Tables\Builders\Models\LeftJoin;
use Zhelyazko777\Tables\Builders\Models\LinkButtonConfig;
use Zhelyazko777\Tables\Builders\Models\ModalButtonConfig;
use Zhelyazko777\Tables\Builders\Models\TableConfig;
use Zhelyazko777\Tables\Builders\Models\TextButtonConfig;
use Zhelyazko777\Tables\Resolvers\Models\ResolvedLinkButton;
use Zhelyazko777\Tables\Resolvers\Models\ResolvedModalButton;
use Zhelyazko777\Tables\Resolvers\Models\ResolvedTextButton;
use Zhelyazko777\Tables\Resolvers\TableResolver;
use Zhelyazko777\Tables\Tests\TestCase;

class TableResolverTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->set_up_db();
    }

    public function test_resolve_should_add_correct_no_data_text()
    {
        $noItemsMsg = 'Test';
        $config = $this
            ->getBasicConfig()
            ->setNoItemsMessage($noItemsMsg);

        $table = (new TableResolver)->resolve($config);

        $this->assertEquals($noItemsMsg, $table->getNoItemsMessage());
    }

    public function test_resolve_should_fetch_correct_results_from_db()
    {
        $config = $this->getBasicConfig();

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
            ->getBasicConfig()
            ->setWhereExpression('pets.name != :name')
            ->setWhereBindings( ['name' => 'Bob']);

        $rows = (new TableResolver)->resolve($config)->getRows();

        $this->assertCount(4, $rows);
        $this->assertEquals('Max', current(array_filter($rows, fn ($r) => $r->id === 1))->{'pets.name'});
        $this->assertEquals('Richard', current(array_filter($rows, fn ($r) => $r->id === 2))->{'pets.name'});
        $this->assertEquals('Vivi', current(array_filter($rows, fn ($r) => $r->id === 3))->{'pets.name'});
        $this->assertEquals('Mani', current(array_filter($rows, fn ($r) => $r->id === 4))->{'pets.name'});
    }

    public function test_resolve_with_join_should_fetch_correct_results()
    {
        $basicConfig = $this->getBasicConfig();
        $config = $basicConfig
            ->setColumns(
                array_merge(
                    $basicConfig->getColumns(),
                    [(new ColumnConfig)->setName('pet_types.name')->setUiName('Type')]
                )
            )
            ->setJoins([
                (new InnerJoin)
                    ->setTable('pet_types')
                    ->setFirstOperand('pets.pet_type_id')
                    ->setOperator('=')
                    ->setSecondOperand('pet_types.id'),
            ]);

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
        $basicConfig = $this->getBasicConfig();
        $config = $this
            ->getBasicConfig()
            ->setColumns(
                array_merge(
                    $basicConfig->getColumns(),
                    [(new ColumnConfig)->setName('toys.name')->setUiName('Toy')]
                )
            )
            ->setJoins([
                (new LeftJoin)
                    ->setTable('toys')
                    ->setFirstOperand('pets.id')
                    ->setOperator('=')
                    ->setSecondOperand('toys.pet_id'),
            ]);

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
            ->getBasicConfig()
            ->setOrderBy('pets.name ASC');

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
            ->getBasicConfig()
            ->setItemsPerPage(1);

        $paginator = (new TableResolver)->resolve($config)->getPaginator();

        $this->assertCount(1, $paginator->items());
        $this->assertEquals(5, $paginator->total());
    }

    public function test_resolve_with_including_sopft_deleted_items_should_return_correct_results()
    {
        $config = $this
            ->getBasicConfig()
            ->setIncludedTrashedTables(['pets']);

        $rows = (new TableResolver)->resolve($config)->getRows();

        $this->assertCount(6, $rows);
    }

    public function test_resolve_should_make_table_expandable_if_method_called()
    {
        $config = $this
            ->getBasicConfig()
            ->setIsExpandable(true);

        $table = (new TableResolver)->resolve($config);

        $this->assertTrue($table->getIsExpandable());
    }

    public function test_resolve_should_add_correct_column_ui_titles()
    {
        $config = $this->getBasicConfig();

        $table = (new TableResolver)->resolve($config);

        $this->assertEquals('Name', $table->getColumns()[0]->getUiName());
    }

    public function test_resolve_should_add_correct_column_name()
    {
        $config = $this->getBasicConfig();

        $table = (new TableResolver)->resolve($config);

        $this->assertEquals('pets.name', $table->getColumns()[0]->getName());
    }

    public function test_resolve_should_add_alias_as_column_name_when_alias_provided()
    {
        $basicConfig = $this->getBasicConfig();
        $alias = 'age_in_test';
        $config = $basicConfig
            ->setColumns(
                array_merge(
                    $basicConfig->getColumns(),
                    [(new ColumnConfig)->setName('age')->setAlias($alias)]
                )
            );

        $table = (new TableResolver)->resolve($config);

        $this->assertEquals($alias, $table->getColumns()[1]->getName());
    }

    public function test_resolve_should_add_link_button_correctly()
    {
        $config = $this->getBasicConfig();

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
        $config = $this->getBasicConfig();

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
        $config = $this->getBasicConfig();

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

        $config = new TableConfig;
        $resolver = new TableResolver;

        $resolver->resolve($config);
    }

    private function getBasicConfig(): TableConfig
    {
        return (new TableConfig())
            ->setMainTable('pets')
            ->setColumns([
                (new ColumnConfig)->setName('pets.name')->setUiName('Name'),
            ])
            ->setButtons([
                (new TextButtonConfig),
                (new LinkButtonConfig),
                (new ModalButtonConfig),
            ]);
    }
}