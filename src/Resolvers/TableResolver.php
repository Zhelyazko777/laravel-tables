<?php

namespace Zhelyazko777\Tables\Resolvers;

use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseJoin;
use Zhelyazko777\Tables\Builders\Models\InnerJoin;
use Zhelyazko777\Tables\Builders\Models\LeftJoin;
use Zhelyazko777\Tables\Builders\Models\SelectColumnConfig;
use Zhelyazko777\Tables\Builders\Models\TableConfig;
use Zhelyazko777\Tables\Models\TableData;
use Zhelyazko777\Tables\Resolvers\Contracts\TableResolverInterface;
use Illuminate\Database\Query\Builder;

class TableResolver implements TableResolverInterface
{
    /**
     * @var array<string>
     */
    private array $tablesWithSoftDelete = [];

    public function resolve(TableConfig $config): TableData
    {
        $this->fetchSoftDeletableTables();

        $tableData = new TableData();
        $columnsToRender = array_filter($config->getColumns(), fn ($c) => !$c->getIsHidden());
        $tableData
            ->setColumns($columnsToRender)
            ->setButtons($config->getButtons())
            ->setNoItemsMessage($config->getNoItemsMessage())
            ->setIsExpandable($config->getIsExpandable());


        $query = $this->buildDbQuery($config);

        $itemsPerPage = $config->getItemsPerPage();
        if ($itemsPerPage !== null) {
            $paginator = $query->paginate($itemsPerPage);
            $resultItems = $paginator->items();
            $tableData->setPaginator($paginator);
        } else {
            $resultItems = $query
                ->get()
                ->toArray();
        }

        $tableData->setRows($resultItems);
        return $tableData;
    }

    /**
     * @param  TableConfig  $config
     * @return Builder
     */
    private function buildDbQuery(TableConfig $config): Builder
    {
        $mainTable = $config->getMainTable();
        $queryBuilder = \DB::table($mainTable);
        $whereExpression = $this->escapeWhere($config->getWhereExpression());
        if (!is_null($whereExpression)) {
            $queryBuilder->whereRaw($whereExpression);
        }
        $this->addSoftDeleteFilter($mainTable, $config->getIncludedTrashedTables(), $queryBuilder);
        $this->addSelects($queryBuilder, $mainTable, $config->getColumns());
        $this->addJoins($queryBuilder, $config->getJoins(), $config->getIncludedTrashedTables());
        $this->addOrderBy($queryBuilder, $mainTable, $config->getOrderBy());

        return $queryBuilder;
    }

    private function fetchSoftDeletableTables(): void
    {
        $dbName = \DB::getDatabaseName();
        $tables = \DB::select("
            SELECT DISTINCT TABLE_NAME FROM information_schema.columns
            WHERE COLUMN_NAME = 'deleted_at' AND TABLE_SCHEMA = '$dbName'
        ");

        foreach ($tables as $table) {
            $this->tablesWithSoftDelete[] = $table->TABLE_NAME;
        }
    }

    /**
     * @param  string  $table
     * @param  array<string>  $includedTrashedTable
     * @param  Builder  $query
     */
    private function addSoftDeleteFilter(string $table, array $includedTrashedTable, Builder $query): void
    {
        if (in_array($table, $this->tablesWithSoftDelete) &&
            !(in_array($table, $includedTrashedTable) || in_array('*', $includedTrashedTable))
        ) {
            $query->whereNull("$table.deleted_at");
        }
    }

    private function addOrderBy(Builder $queryBuilder, string $mainTable, ?string $orderBy): void
    {
        if ($orderBy) {
            $id = \request()->query('itemId');
            if (!is_null($id) && !is_array($id)) {
                $queryBuilder->orderByRaw("FIELD($mainTable.id, :id) DESC," . $orderBy, [ 'id' => $id ]);
            } else {
                $queryBuilder->orderByRaw($orderBy);
            }
        }
    }

    /**
     * @param  Builder  $queryBuilder
     * @param  string  $table
     * @param  array<SelectColumnConfig>  $selectColumns
     */
    private function addSelects(Builder $queryBuilder, string $table, array $selectColumns): void
    {
        $queryBuilder
            ->selectRaw("$table.id as id, " .  $this->mapSelectColumns($selectColumns));
    }

    /**
     * @param  array<SelectColumnConfig>  $selectColumns
     * @return string
     */
    private function mapSelectColumns(array $selectColumns): string
    {
        return collect($selectColumns)
            ->map(fn(SelectColumnConfig $col) => $col->getColumn() . " as " . "'" . $col->getUiColumnName(). "'")
            ->values()
            ->implode(', ');
    }

    /**
     * @param  Builder  $queryBuilder
     * @param  array<BaseJoin>  $joins
     * @param  array<string>  $includedTrashedTable
     */
    private function addJoins(Builder $queryBuilder, array $joins, array $includedTrashedTable): void
    {
        foreach ($joins as $join)
        {
            $joinClass = get_class($join);
            if ($joinClass === LeftJoin::class) {
                $queryBuilder->leftJoin(
                    $join->getTable(),
                    $join->getFirstOperand(),
                    $join->getOperator(),
                    $join->getSecondOperand()
                );
            } else if ($joinClass === InnerJoin::class) {
                $queryBuilder->join(
                    $join->getTable(),
                    $join->getFirstOperand(),
                    $join->getOperator(),
                    $join->getSecondOperand()
                );
            }
            $this->addSoftDeleteFilter($join->getTable(), $includedTrashedTable, $queryBuilder);
        }
//        $this->traverseJoins($joins, function ($tableToJoin, $condition) use ($queryBuilder, $includedTrashedTable) {
//            $queryBuilder->join($tableToJoin, $condition[0], $condition[1], $condition[2]);
//            $this->addSoftDeleteFilter($tableToJoin, $includedTrashedTable, $queryBuilder);
//        });
    }

//    /**
//     * @param  Builder  $queryBuilder
//     * @param  array<mixed>  $joins
//     * @param  array<string>  $includedTrashedTable
//     */
//    private function addLeftJoins(Builder $queryBuilder, array $joins, array $includedTrashedTable): void
//    {
//        $this->traverseJoins($joins, function ($tableToJoin, $condition) use ($queryBuilder, $includedTrashedTable) {
//            $queryBuilder->leftJoin($tableToJoin, $condition[0], $condition[1], $condition[2]);
//            $this->addSoftDeleteFilter($tableToJoin, $includedTrashedTable, $queryBuilder);
//        });
//    }

    /**
     * @param  array<string, mixed>  $joins
     * @param  callable  $callback
     */
    private function traverseJoins(array $joins, callable $callback): void
    {
        foreach ($joins as $join => $conditions) {
            $callback(
                $join,
                $conditions[0],
            );
        }
    }

    private function escapeWhere(?string $whereExpression): ?string
    {
        if (is_null($whereExpression)) {
            return null;
        }

        return str_replace("\\", "\\\\", $whereExpression);
    }
}
