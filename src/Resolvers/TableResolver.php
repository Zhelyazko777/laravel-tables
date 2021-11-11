<?php

namespace Zhelyazko777\Tables\Resolvers;

use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;
use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseButtonConfig;
use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseJoin;
use Zhelyazko777\Tables\Builders\Models\InnerJoin;
use Zhelyazko777\Tables\Builders\Models\LeftJoin;
use Zhelyazko777\Tables\Builders\Models\ColumnConfig;
use Zhelyazko777\Tables\Builders\Models\TableConfig;
use Zhelyazko777\Tables\Resolvers\Contracts\TableResolverInterface;
use Illuminate\Database\Query\Builder;
use Zhelyazko777\Tables\Resolvers\Models\ResolvedColumn;
use Zhelyazko777\Tables\Resolvers\Models\ResolvedTable;

class TableResolver implements TableResolverInterface
{
    /**
     * @var array<string>
     */
    private array $tablesWithSoftDelete = [];

    public function resolve(TableConfig $config): ResolvedTable
    {
        $this->fetchSoftDeletableTables();

        $resolvedTable = new ResolvedTable();
        $resolvedTable->setNoItemsMessage($config->getNoItemsMessage());
        $resolvedTable->setIsExpandable($config->getIsExpandable());
        $this->addColumns($resolvedTable, $config->getColumns());
        $this->addButtons($resolvedTable, $config->getButtons());
        $this->addRows($resolvedTable, $config);

        return $resolvedTable;
    }

    /**
     * @param  ResolvedTable  $table
     * @param  TableConfig  $config
     */
    private function addRows(ResolvedTable $table, TableConfig $config): void
    {
        $query = $this->buildDbQuery($config);
        $itemsPerPage = $config->getItemsPerPage();

        $rows = null;
        if ($itemsPerPage !== null) {
            $paginator = $query->paginate($itemsPerPage);
            $rows = $paginator->items();
            $table->setPaginator($paginator);
        } else {
            $rows = $query->get()->toArray();
        }

        $table->setRows($rows);
    }

    /**
     * @param  ResolvedTable  $table
     * @param  array<BaseButtonConfig>  $buttonsConfig
     */
    private function addButtons(ResolvedTable $table, array $buttonsConfig): void
    {
        $table
            ->setButtons(array_map(function (BaseButtonConfig $button) {
                $btnType = 'Zhelyazko777\Tables\Resolvers\Models\Resolved' . ucfirst($button->getType()) . 'Button';
                return  SimpleMapper::map($button, new $btnType);
            }, $buttonsConfig));
    }

    /**
     * @param  ResolvedTable  $table
     * @param  array<ColumnConfig>  $columnsConfig
     */
    private function addColumns(ResolvedTable $table, array $columnsConfig): void
    {
        $resolvedColumns = [];

        foreach ($columnsConfig as $column)
        {
            if (!$column->getIsHidden()) {
                $resolvedColumns[] = SimpleMapper::map(
                    $column,
                    new ResolvedColumn,
                    [
                        'name' => fn (ColumnConfig $source) => (!is_null($source->getAlias())) ? $source->getAlias() : $source->getName(),
                    ]
                );
            }
        }

        $table->setColumns($resolvedColumns);
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
            $queryBuilder->whereRaw($whereExpression, $config->getWhereBindings());
        }
        $this->addSoftDeleteFilter($mainTable, $config->getIncludedTrashedTables(), $queryBuilder);
        $this->addSelects($queryBuilder, $mainTable, $config->getColumns());
        $this->addJoins($queryBuilder, $config->getJoins(), $config->getIncludedTrashedTables());
        $this->addOrderBy($queryBuilder, $mainTable, $config->getOrderBy(), $config->getOrderByBindings());

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
     * @param  array<string>  $includedTrashedTables
     * @param  Builder  $query
     */
    private function addSoftDeleteFilter(string $table, array $includedTrashedTables, Builder $query): void
    {
        if (in_array($table, $this->tablesWithSoftDelete) &&
            !(in_array($table, $includedTrashedTables) || in_array('*', $includedTrashedTables))
        ) {
            $query->whereNull("$table.deleted_at");
        }
    }

    private function addOrderBy(Builder $queryBuilder, string $mainTable, ?string $orderBy, array $bindings): void
    {
        if ($orderBy) {
            $id = \request()->query('itemId');
            if (!is_null($id) && !is_array($id)) {
                $queryBuilder->orderByRaw(
                    "FIELD($mainTable.id, :id) DESC," . $orderBy,
                    array_merge([ 'id' => $id ], $bindings)
                );
            } else {
                $queryBuilder->orderByRaw($orderBy, $bindings);
            }
        }
    }

    /**
     * @param  Builder  $queryBuilder
     * @param  string  $table
     * @param  array<ColumnConfig>  $selectColumns
     */
    private function addSelects(Builder $queryBuilder, string $table, array $selectColumns): void
    {
        $queryBuilder
            ->selectRaw("$table.id as id, " .  $this->mapSelectColumns($selectColumns));
    }

    /**
     * @param  array<ColumnConfig>  $selectColumns
     * @return string
     */
    private function mapSelectColumns(array $selectColumns): string
    {
        return collect($selectColumns)
            ->map(fn(ColumnConfig $col) => $col->getName() . " as " . (is_null($col->getAlias()) ? "'" . $col->getName() . "'" :  "'" . $col->getAlias(). "'"))
            ->values()
            ->implode(', ');
    }

    /**
     * @param  Builder  $queryBuilder
     * @param  array<BaseJoin>  $joins
     * @param  array<string>  $includedTrashedTables
     */
    private function addJoins(Builder $queryBuilder, array $joins, array $includedTrashedTables): void
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
            $this->addSoftDeleteFilter($join->getTable(), $includedTrashedTables, $queryBuilder);
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
