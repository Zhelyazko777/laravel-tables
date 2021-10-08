<?php

namespace Zhelyazko777\Tables;

use Zhelyazko777\Tables\Resolvers\Contracts\TableResolverInterface;
use Zhelyazko777\Tables\Resolvers\TableResolver;
use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    public array $bindings = [
        TableResolverInterface::class => TableResolver::class,
    ];

    public function register()
    {
        $this->app->bind('table', function(){
            return new Table;
        });
    }
}
