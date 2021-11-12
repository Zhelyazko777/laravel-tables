<?php

namespace Zhelyazko777\Tables\Builders;

use Zhelyazko777\Utilities\Contracts\CanExport;
use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseJoin;
use Zhelyazko777\Tables\Builders\Models\InnerJoin;
use Zhelyazko777\Tables\Builders\Models\LeftJoin;
use Zhelyazko777\Tables\Builders\Models\TableConfig;

class TableBuilder implements CanExport
{
    private TableConfig $config;

    public function __construct()
    {
        $this->config = new TableConfig();
    }

    /**
     * Sets the table from which th query should start
     * @param  string  $table
     * @return $this
     */
    public function fromDbTable(string $table): self
    {
        $this->config->setMainTable($table);
        return $this;
    }

    /**
     * Adds button which opens a modal
     * @param  callable  $callback
     * @return $this
     */
    public function addModalButton(callable $callback): self
    {
        $builder = new ModalButtonBuilder();
        $callback($builder);
        $this->config->setButtons(
            array_merge(
                $this->config->getButtons(),
                [$builder->export()]
            )
        );

        return $this;
    }

    /**
     * Adds button of type link
     * @param  callable  $callback
     * @return $this
     */
    public function addLinkButton(callable $callback): self
    {
        $builder = new LinkButtonBuilder();
        $callback($builder);
        $this->config->setButtons(
            array_merge(
                $this->config->getButtons(),
                [$builder->export()],
            )
        );

        return $this;
    }

    /**
     * Adds simple text button(useful when you need just to add
     * JS event listener on it)
     * @param  callable  $callback
     * @return $this
     */
    public function addTextButton(callable $callback): self
    {
        $builder = new TextButtonBuilder();
        $callback($builder);
        $this->config->setButtons(
            array_merge(
                $this->config->getButtons(),
                [$builder->export()],
            )
        );

        return $this;
    }

    /**
     * Builds a column selection
     * @param  callable  $callback
     * @return $this
     */
    public function selectColumn(callable $callback): self
    {
        $builder = new ColumnBuilder();
        $callback($builder);
        $this->config->setColumns(
            array_merge(
                $this->config->getColumns(),
                [$builder->export()],
            ),
        );

        return $this;
    }

    /**
     * Adds INNER JOIN to the query
     * @param  string  $table
     * @param  string  $firstOperand
     * @param  string  $operator
     * @param  string  $secondOperand
     * @return $this
     */
    public function addJoin(string $table, string $firstOperand, string $operator, string $secondOperand): self
    {
        $this->config->setJoins(
            array_merge(
                $this->config->getJoins(),
                [$this->fillJoinInfo(new InnerJoin(), $table, $firstOperand, $operator, $secondOperand)]
            ),
        );

        return $this;
    }

    /**
     * Adds LEFT JOIN to the query
     * @param  string  $table
     * @param  string  $firstOperand
     * @param  string  $operator
     * @param  string  $secondOperand
     * @return $this
     */
    public function addLeftJoin(string $table, string $firstOperand, string $operator, string $secondOperand): self
    {
        $this->config->setJoins(
            array_merge(
                $this->config->getJoins(),
                [$this->fillJoinInfo(new LeftJoin(), $table, $firstOperand, $operator, $secondOperand)]
            ),
        );

        return $this;
    }

    /**
     * Adds order by statement to the query
     * @param  string  $orderBy
     * @param  array  $bindings
     * @return $this
     */
    public function orderBy(string $orderBy, array $bindings = []): self
    {
        $this->config->setOrderByBindings($bindings);
        $this->config->setOrderBy($orderBy);
        return $this;
    }

    /**
     * Makes the rows expandable
     * (useful when hiding columns on mobile)
     * @return $this
     */
    public function makeExpandable(): self
    {
        $this->config->setIsExpandable(true);
        return $this;
    }

    /**
     * Adds text to show when there are no items
     * @param  string  $noDataMessage
     * @return $this
     */
    public function ifNoDataShow(string $noDataMessage): self
    {
        $this->config->setNoItemsMessage($noDataMessage);
        return $this;
    }

    /**
     * Paginates the table
     * @param  int  $itemsPerPage
     * @return $this
     */
    public function paginate(int $itemsPerPage): self
    {
        $this->config->setItemsPerPage($itemsPerPage);
        return $this;
    }

    /**
     * Adds WHERE statement to the query
     * @param  string  $whereExpression
     * @param  array  $bindings
     * @return $this
     */
    public function filter(string $whereExpression, array $bindings = []): self
    {
        $this->config->setWhereExpression($whereExpression);
        $this->config->setWhereBindings($bindings);
        return $this;
    }

    /**
     * Includes soft deleted records
     * @param  array<string>  $columns
     * @return $this
     */
    public function includeTrashed(?array $columns = []): self
    {
        $this->config->setIncludedTrashedTables(
            array_merge(
                $this->config->getIncludedTrashedTables(),
                $columns
            )
        );

        return $this;
    }

    /**
     * Exports table config
     * @return TableConfig
     */
    public function export(): TableConfig
    {
        return $this->config;
    }

    private function fillJoinInfo(BaseJoin $join, string $table,  string $firstOperand, string $operator, string $secondOperand): BaseJoin
    {
        $join->setTable($table);
        $join->setFirstOperand($firstOperand);
        $join->setOperator($operator);
        $join->setSecondOperand($secondOperand);

        return $join;
    }
}
