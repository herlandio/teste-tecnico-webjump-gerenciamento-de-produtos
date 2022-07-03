<?php


namespace Help;


class BaseView {

    private $title;
    private $header;
    private $body;
    private $footer;

    /**
     * Show templates of view
     * @param $folder
     */
    public function Folder($folder) {
        require __DIR__.'../../views/index.php';
        $this->setHeader(require(__DIR__.'../../views/'.$folder.'header.php'));
        $this->setBody(require(__DIR__.'../../views/'.$folder.'body.php'));
        $this->setFooter(require(__DIR__.'../../views/'.$folder.'footer.php'));
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @param mixed $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getFooter()
    {
        return $this->footer;
    }

}