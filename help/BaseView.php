<?php

namespace Help;

class BaseView {

    private const VIEWS_DIR = __DIR__ . '../../views/';

    private string $title;
    private string $header;
    private string $body;
    private string $footer;

    public function __construct() {
        $this->title    = '';
        $this->header   = '';
        $this->body     = '';
        $this->footer   = '';
    }

    /**
     * Show templates of view
     *
     * @param string $folder The folder containing the view templates
     * @return void
     */
    public function folder(string $folder): void {
        require self::VIEWS_DIR . 'index.php';
        $this->setHeader(require self::VIEWS_DIR . $folder . 'header.php');
        $this->setBody(require self::VIEWS_DIR . $folder . 'body.php');
        $this->setFooter(require self::VIEWS_DIR . $folder . 'footer.php');
    }

    /**
     * Set the title of the view
     *
     * @param string $title The title to set
     * @return void
     */
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    /**
     * Get the title of the view
     *
     * @return string The title of the view
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Set the header content of the view
     *
     * @param string $header The header content to set
     * @return void
     */
    public function setHeader(string $header): void {
        $this->header = $header;
    }

    /**
     * Set the body content of the view
     *
     * @param string $body The body content to set
     * @return void
     */
    public function setBody(string $body): void {
        $this->body = $body;
    }

    /**
     * Set the footer content of the view
     *
     * @param string $footer The footer content to set
     * @return void
     */
    public function setFooter(string $footer): void {
        $this->footer = $footer;
    }

    /**
     * Get the header content of the view
     *
     * @return string The header content of the view
     */
    public function getHeader(): string {
        return $this->header;
    }

    /**
     * Get the body content of the view
     *
     * @return string The body content of the view
     */
    public function getBody(): string {
        return $this->body;
    }

    /**
     * Get the footer content of the view
     *
     * @return string The footer content of the view
     */
    public function getFooter(): string {
        return $this->footer;
    }
}
