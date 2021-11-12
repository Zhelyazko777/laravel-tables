<?php

namespace Zhelyazko777\Tables\Tests\Builders;

use Zhelyazko777\Tables\Builders\Abstractions\BaseButtonBuilder;
use Zhelyazko777\Tables\Builders\ModalButtonBuilder;
use Zhelyazko777\Tables\Builders\Models\ModalButtonConfig;
use Zhelyazko777\Tables\Tests\Builders\Abstractions\BaseButtonBuilderTest;

class ModalButtonBuilderTest extends BaseButtonBuilderTest
{
    /** @var ModalButtonBuilder */
    protected BaseButtonBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new ModalButtonBuilder();
    }

    public function test_export_should_return_modal_button_config_instance()
    {
        $instance = $this->builder->export();

        $this->assertEquals(ModalButtonConfig::class, get_class($instance));
    }

    public function test_with_modal_id_should_set_modal_id_in_the_config()
    {
        $modalId = 'test-id';

        $this->builder->withModalId($modalId);

        /** @var $config ModalButtonConfig */
        $config = $this->builder->export();
        $this->assertEquals($modalId, $config->getModalId());
    }

    public function test_with_action_route_should_set_modal_action_route_in_the_config()
    {
        $route = '/test';

        $this->builder->withActionRoute($route);

        /** @var $config ModalButtonConfig */
        $config = $this->builder->export();
        $this->assertEquals($route, $config->getModalActionRoute());
    }

    public function test_with_modal_heading_text_should_add_modal_heading_text_to_config()
    {
        $heading = 'Test heading';

        $this->builder->withModalHeadingText($heading);

        /** @var $config ModalButtonConfig */
        $config = $this->builder->export();
        $this->assertEquals($heading, $config->getModalHeadingText());
    }


    public function test_with_modal_body_text_should_add_modal_body_text_to_config()
    {
        $body = 'Test body';

        $this->builder->withModalBodyText($body);

        /** @var $config ModalButtonConfig */
        $config = $this->builder->export();
        $this->assertEquals($body, $config->getModalBodyText());
    }

    public function test_with_cancel_text_should_add_modal_btn_cancel_text_to_config()
    {
        $text = 'Cancel';

        $this->builder->withCancelText($text);

        /** @var $config ModalButtonConfig */
        $config = $this->builder->export();
        $this->assertEquals($text, $config->getModalCancelText());
    }

    public function test_with_submit_text_should_add_modal_btn_submit_text_to_config()
    {
        $text = 'Submit';

        $this->builder->withSubmitText($text);

        /** @var $config ModalButtonConfig */
        $config = $this->builder->export();
        $this->assertEquals($text, $config->getModalSubmitText());
    }

    public function test_with_colcor_should_add_modal_color_to_config()
    {
        $color = '#000';

        $this->builder->withColor($color);

        /** @var $config ModalButtonConfig */
        $config = $this->builder->export();
        $this->assertEquals($color, $config->getModalColor());
    }
}