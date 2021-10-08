<?php

namespace Zhelyazko777\Tables;

use Zhelyazko777\Tables\Builders\TableBuilder;
use Zhelyazko777\Tables\Contracts\TableConfigurationInterface;
use Zhelyazko777\Tables\Models\TableData;
use Zhelyazko777\Tables\Resolvers\Contracts\TableResolverInterface;

class Table
{
    public function create(TableConfigurationInterface $table): TableData
    {
        $resolver = app()->get(TableResolverInterface::class);
        $builder = new TableBuilder();
        $table->build($builder);

        return $resolver->resolve($builder->export());
    }
}
