<?php

declare(strict_types=1);

namespace Help;

class BaseView {

    private string $title;
    private string $header;
    private string $body;
    private string $footer;

    /**
     * Show templates of view
     *
     * @param $folder
     */
    public function folder(string $folder): void {
        require __DIR__.'../../views/index.php';
        $this->setHeader(require(__DIR__.'../../views/'.$folder.'header.php'));
        $this->setBody(require(__DIR__.'../../views/'.$folder.'body.php'));
        $this->setFooter(require(__DIR__.'../../views/'.$folder.'footer.php'));
    }

    /**
     * Set title page
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get title page
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set header page
     *
     * @param string $header
     */
    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    /**
     * Set body page
     *
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * Set footer page
     *
     * @param string $footer
     */
    public function setFooter(string $footer): void
    {
        $this->footer = $footer;
    }

    /**
     * Get header page
     *
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * Set body page
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Set footer page
     *
     * @return string
     */
    public function getFooter(): string
    {
        return $this->footer;
    }

}
