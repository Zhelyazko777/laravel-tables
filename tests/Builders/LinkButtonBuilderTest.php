<?php

namespace Zhelyazko777\Tables\Tests\Builders;

use Zhelyazko777\Tables\Builders\Abstractions\BaseButtonBuilder;
use Zhelyazko777\Tables\Builders\LinkButtonBuilder;
use Zhelyazko777\Tables\Builders\Models\LinkButtonConfig;
use Zhelyazko777\Tables\Tests\Builders\Abstractions\BaseButtonBuilderTest;

class LinkButtonBuilderTest extends BaseButtonBuilderTest
{
    /** @var LinkButtonBuilder */
    protected BaseButtonBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new LinkButtonBuilder();
    }

    public function test_export_should_return_link_button_config_instance()
    {
        $instance = $this->builder->export();

        $this->assertEquals(LinkButtonConfig::class, get_class($instance));
    }

    public function test_on_click_go_to_should_set_route_in_the_config()
    {
        $route = '/test';

        $this->builder->onClickGoTo($route);

        /** @var $config LinkButtonConfig */
        $config = $this->builder->export();
        $this->assertEquals($route, $config->getRoute());
    }

}