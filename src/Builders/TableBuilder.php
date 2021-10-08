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

    public function fromDbTable(string $table): self
    {
        $this->config->setMainTable($table);
        return $this;
    }

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

    public function selectColumn(callable $callback): self
    {
        $builder = new SelectColumnBuilder();
        $callback($builder);
        $this->config->setColumns(
            array_merge(
                $this->config->getColumns(),
                [$builder->export()],
            ),
        );

        return $this;
    }

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

    public function orderBy(string $orderBy): self
    {
        $this->config->setOrderBy($orderBy);
        return $this;
    }

    public function makeExpandable(): self
    {
        $this->config->setIsExpandable(true);
        return $this;
    }

    public function ifNoDataShow(string $nodDataMessage): self
    {
        $this->config->setNoItemsMessage($nodDataMessage);
        return $this;
    }

    public function paginate(int $itemsPerPage): self
    {
        $this->config->setItemsPerPage($itemsPerPage);
        return $this;
    }

    public function filter(string $whereExpression): self
    {
        $this->config->setWhereExpression($whereExpression);
        return $this;
    }

    /**
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
