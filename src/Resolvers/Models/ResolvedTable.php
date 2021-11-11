<?php

namespace Zhelyazko777\Tables\Resolvers\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Zhelyazko777\Tables\Resolvers\Models\Abstractions\BaseResolvedButton;
use Zhelyazko777\Utilities\Exportable;

class ResolvedTable implements \JsonSerializable
{
    use Exportable;

    /** @var array<ResolvedColumn> */
    private array $columns = [];

    /** @var array<string> */
    private array $rows = [];

    /** @var array<BaseResolvedButton> */
    private array $buttons = [];

    private ?LengthAwarePaginator $paginator = null;

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
     * @return self
     */
    public function setNoItemsMessage($noItemsMessage): self
    {
        $this->noItemsMessage = $noItemsMessage;
        return $this;
    }

    /**
     * @return array<BaseResolvedButton>
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    /**
     * @param array<BaseResolvedButton>  $buttons
     * @return self
     */
    public function setButtons(array $buttons): self
    {
        $this->buttons = $buttons;
        return $this;
    }

    /**
     * @return array<ResolvedColumn>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param  array<ResolvedColumn>  $columns
     * @return self
     */
    public function setColumns(array $columns): self
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
     * @return self
     */
    public function setRows(array $rows): self
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return LengthAwarePaginator|null
     */
    public function getPaginator(): ?LengthAwarePaginator
    {
        return $this->paginator;
    }

    /**
     * @param  LengthAwarePaginator|null  $paginator
     * @return self
     */
    public function setPaginator(?LengthAwarePaginator $paginator): self
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
     * @return self
     */
    public function setIsExpandable(bool $isExpandable): self
    {
        $this->isExpandable = $isExpandable;
        return $this;
    }
}