<?php

namespace Zhelyazko777\Tables\Builders\Models\Abstractions;

abstract class BaseJoin
{
    /**
     * @var string
     */
    private string $table;

    /**
     * @var string
     */
    private string $firstOperand;

    /**
     * @var string
     */
    private string $operator;

    /**
     * @var string
     */
    private string $secondOperand;

    /**
     * @return string
     */
    public function getFirstOperand(): string
    {
        return $this->firstOperand;
    }

    /**
     * @param  string  $firstOperand
     * @return BaseJoin
     */
    public function setFirstOperand(string $firstOperand): BaseJoin
    {
        $this->firstOperand = $firstOperand;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @param  string  $operator
     * @return BaseJoin
     */
    public function setOperator(string $operator): BaseJoin
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecondOperand(): string
    {
        return $this->secondOperand;
    }

    /**
     * @param  string  $secondOperand
     * @return BaseJoin
     */
    public function setSecondOperand(string $secondOperand): BaseJoin
    {
        $this->secondOperand = $secondOperand;
        return $this;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param  string  $table
     * @return BaseJoin
     */
    public function setTable(string $table): BaseJoin
    {
        $this->table = $table;
        return $this;
    }
}
