<?php

namespace Zhelyazko777\Tables\Models;

use Zhelyazko777\Tables\Builders\Models\SelectColumnConfig;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Zhelyazko777\Utilities\Exportable;

class TableData implements \JsonSerializable
{
    use Exportable;

    /**
     * @var array<SelectColumnConfig>
     */
    private array $columns = [];

    /**
     * @var array<string>
     */
    private array $rows = [];

    /**
     * @var array<mixed>
     */
    private array $buttons = [];

    private LengthAwarePaginator $paginator;

    private string $noItemsMessage;

    private bool $isExpandable = false;

    /**
     * @return string
     */
    public function getNoItemsMessage(): string
    {
        return $this->noItemsMessage;
    }

    /**
     * @param  mixed  $noItemsMessage
     * @return TableData
     */
    public function setNoItemsMessage($noItemsMessage): TableData
    {
        $this->noItemsMessage = $noItemsMessage;
        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    /**
     * @param mixed[]  $buttons
     * @return TableData
     */
    public function setButtons(array $buttons): TableData
    {
        $this->buttons = $buttons;
        return $this;
    }

    /**
     * @return array<SelectColumnConfig>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param  array<SelectColumnConfig>  $columns
     * @return TableData
     */
    public function setColumns(array $columns): TableData
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return array<string>
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @param array<string> $rows
     * @return TableData
     */
    public function setRows(array $rows): TableData
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    /**
     * @param  LengthAwarePaginator  $paginator
     * @return TableData
     */
    public function setPaginator(LengthAwarePaginator $paginator): TableData
    {
        $this->paginator = $paginator;
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
     * @return TableData
     */
    public function setIsExpandable(bool $isExpandable): TableData
    {
        $this->isExpandable = $isExpandable;
        return $this;
    }
}
