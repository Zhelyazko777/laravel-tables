<?php

namespace Zhelyazko777\Tables\Builders\Models;

use Zhelyazko777\Tables\Builders\Models\Abstractions\BaseButtonConfig;

class ModalButtonConfig extends BaseButtonConfig
{
    private string $modalId = '';

    private string $modalActionRoute = '';

    private string $modalHeadingText = '';

    private string $modalBodyText = '';

    private string $modalCancelText = '';

    private string $modalSubmitText = '';

    private string $modalColor = '';

    /**
     * @return string
     */
    public function getModalId(): string
    {
        return $this->modalId;
    }

    /**
     * @param  string  $modalId
     * @return ModalButtonConfig
     */
    public function setModalId(string $modalId): ModalButtonConfig
    {
        $this->modalId = $modalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getModalActionRoute(): string
    {
        return $this->modalActionRoute;
    }

    /**
     * @param  string  $modalActionRoute
     * @return ModalButtonConfig
     */
    public function setModalActionRoute(string $modalActionRoute): ModalButtonConfig
    {
        $this->modalActionRoute = $modalActionRoute;
        return $this;
    }

    /**
     * @return string
     */
    public function getModalHeadingText(): string
    {
        return $this->modalHeadingText;
    }

    /**
     * @param  string  $modalHeadingText
     * @return ModalButtonConfig
     */
    public function setModalHeadingText(string $modalHeadingText): ModalButtonConfig
    {
        $this->modalHeadingText = $modalHeadingText;
        return $this;
    }

    /**
     * @return string
     */
    public function getModalBodyText(): string
    {
        return $this->modalBodyText;
    }

    /**
     * @param  string  $modalBodyText
     * @return ModalButtonConfig
     */
    public function setModalBodyText(string $modalBodyText): ModalButtonConfig
    {
        $this->modalBodyText = $modalBodyText;
        return $this;
    }

    /**
     * @return string
     */
    public function getModalCancelText(): string
    {
        return $this->modalCancelText;
    }

    /**
     * @param  string  $modalCancelText
     * @return ModalButtonConfig
     */
    public function setModalCancelText(string $modalCancelText): ModalButtonConfig
    {
        $this->modalCancelText = $modalCancelText;
        return $this;
    }

    /**
     * @return string
     */
    public function getModalSubmitText(): string
    {
        return $this->modalSubmitText;
    }

    /**
     * @param  string  $modalSubmitText
     * @return ModalButtonConfig
     */
    public function setModalSubmitText(string $modalSubmitText): ModalButtonConfig
    {
        $this->modalSubmitText = $modalSubmitText;
        return $this;
    }

    /**
     * @return string
     */
    public function getModalColor(): string
    {
        return $this->modalColor;
    }

    /**
     * @param  string  $color
     * @return ModalButtonConfig
     */
    public function setModalColor(string $color): ModalButtonConfig
    {
        $this->modalColor = $color;
        return $this;
    }
}
