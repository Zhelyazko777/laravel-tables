<?php

namespace Zhelyazko777\Tables\Builders\Models;

use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseButtonConfig;
use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseJoin;

class TableConfig
{
    /**
     * @var array<ColumnConfig>
     */
    private array $columns = [];

    /**
     * @var array<BaseButtonConfig>
     */
    private array $buttons = [];

    /**
     * @var array<string, mixed>
     */
    private array $joins = [];

    /**
     * @var array<string>
     */
    private array $includedTrashedTables = [];

    private string $mainTable = '';

    private ?int $itemsPerPage = null;

    private ?string $orderBy = null;

    private bool $isExpandable = false;

    private string $noItemsMessage = '';

    private ?string $whereExpression = null;

    /** @var array<string, mixed> */
    private array $whereBindings = [];

    /** @var array<string, mixed> */
    private array $orderByBindings = [];

    /**
     * @return string[]
     */
    public function getIncludedTrashedTables(): array
    {
        return $this->includedTrashedTables;
    }

    /**
     * @param  string[]  $includedTrashedTables
     * @return TableConfig
     */
    public function setIncludedTrashedTables(array $includedTrashedTables): TableConfig
    {
        $this->includedTrashedTables = $includedTrashedTables;
        return $this;
    }

    /**
     * @return array<ColumnConfig>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param  array<ColumnConfig>  $columns
     * @return TableConfig
     */
    public function setColumns(array $columns): TableConfig
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return array<BaseButtonConfig>
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    /**
     * @param  array<BaseButtonConfig>  $buttons
     * @return TableConfig
     */
    public function setButtons(array $buttons): TableConfig
    {
        $this->buttons = $buttons;
        return $this;
    }

    /**
     * @return array<BaseJoin>
     */
    public function getJoins(): array
    {
        return $this->joins;
    }

    /**
     * @param  array<BaseJoin>  $joins
     * @return TableConfig
     */
    public function setJoins(array $joins): TableConfig
    {
        $this->joins = $joins;
        return $this;
    }

    /**
     * @return string
     */
    public function getMainTable(): string
    {
        return $this->mainTable;
    }

    /**
     * @param  string  $mainTable
     * @return TableConfig
     */
    public function setMainTable(string $mainTable): TableConfig
    {
        $this->mainTable = $mainTable;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getItemsPerPage(): ?int
    {
        return $this->itemsPerPage;
    }

    /**
     * @param  int|null  $itemsPerPage
     * @return TableConfig
     */
    public function setItemsPerPage(?int $itemsPerPage): TableConfig
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @param  string|null  $orderBy
     * @return TableConfig
     */
    public function setOrderBy(?string $orderBy): TableConfig
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsExpandable(): bool
    {
        return $this->isExpandable;
    }

    /**
     * @param  bool  $isExpandable
     * @return TableConfig
     */
    public function setIsExpandable(bool $isExpandable): TableConfig
    {
        $this->isExpandable = $isExpandable;
        return $this;
    }

    /**
     * @return string
     */
    public function getNoItemsMessage(): string
    {
        return $this->noItemsMessage;
    }

    /**
     * @param  string  $noItemsMessage
     * @return TableConfig
     */
    public function setNoItemsMessage(string $noItemsMessage): TableConfig
    {
        $this->noItemsMessage = $noItemsMessage;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getWhereExpression(): ?string
    {
        return $this->whereExpression;
    }

    /**
     * @param  string  $whereExpression
     * @return TableConfig
     */
    public function setWhereExpression(string $whereExpression): TableConfig
    {
        $this->whereExpression = $whereExpression;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getWhereBindings(): array
    {
        return $this->whereBindings;
    }

    /**
     * @param  array<string, mixed>  $whereBindings
     * @return TableConfig
     */
    public function setWhereBindings(array $whereBindings): TableConfig
    {
        $this->whereBindings = $whereBindings;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOrderByBindings(): array
    {
        return $this->orderByBindings;
    }

    /**
     * @param  array<string, mixed>  $orderByBindings
     * @return TableConfig
     */
    public function setOrderByBindings(array $orderByBindings): TableConfig
    {
        $this->orderByBindings = $orderByBindings;
        return $this;
    }
}
