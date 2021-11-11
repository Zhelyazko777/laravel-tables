<?php

namespace Zhelyazko777\Tables\Resolvers\Models;

use Zhelyazko777\Tables\Resolvers\Models\Abstractions\BaseResolvedButton;

class ResolvedModalButton extends BaseResolvedButton
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
     * @return self
     */
    public function setModalId(string $modalId): self
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
     * @return self
     */
    public function setModalActionRoute(string $modalActionRoute): self
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
     * @return self
     */
    public function setModalHeadingText(string $modalHeadingText): self
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
     * @return self
     */
    public function setModalBodyText(string $modalBodyText): self
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
     * @return self
     */
    public function setModalCancelText(string $modalCancelText): self
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
     * @return self
     */
    public function setModalSubmitText(string $modalSubmitText): self
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
     * @return self
     */
    public function setModalColor(string $color): self
    {
        $this->modalColor = $color;
        return $this;
    }
}