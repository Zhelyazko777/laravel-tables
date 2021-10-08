<?php

namespace Zhelyazko777\Tables\Contracts;

use Zhelyazko777\Tables\Builders\TableBuilder;

interface TableConfigurationInterface
{
    public function build(TableBuilder $builder): void;
}
