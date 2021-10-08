<?php

namespace Zhelyazko777\Tables\Resolvers\Contracts;

use Zhelyazko777\Tables\Builders\Models\TableConfig;
use Zhelyazko777\Tables\Models\TableData;

interface TableResolverInterface
{
    public function resolve(TableConfig $config): TableData;
}
