<?php

declare(strict_types=1);

namespace Tests\Help;

use Help\BaseView;
use PHPUnit\Framework\TestCase;

class BaseViewTest extends TestCase
{
    private BaseView $view;

    protected function setUp(): void
    {
        $this->view = new BaseView();
    }

    /**
     * Tests setting and getting the title.
     */
    public function testSetAndGetTitle(): void
    {
        $this->view->setTitle('Test Title');
        $this->assertEquals('Test Title', $this->view->getTitle());
    }

    /**
     * Tests setting and getting the header.
     */
    public function testSetAndGetHeader(): void
    {
        $headerContent = '<h1>Header</h1>';
        $this->view->setHeader($headerContent);
        $this->assertEquals($headerContent, $this->view->getHeader());
    }

    /**
     * Tests setting and getting the body.
     */
    public function testSetAndGetBody(): void
    {
        $bodyContent = '<p>Body content</p>';
        $this->view->setBody($bodyContent);
        $this->assertEquals($bodyContent, $this->view->getBody());
    }

    /**
     * Tests setting and getting the footer.
     */
    public function testSetAndGetFooter(): void
    {
        $footerContent = '<footer>Footer</footer>';
        $this->view->setFooter($footerContent);
        $this->assertEquals($footerContent, $this->view->getFooter());
    }

    /**
     * Tests if the folder loads correctly by checking header, body, and footer.
     */
    public function testFolderLoadsCorrectly(): void
    {
        $headerContent = '<h1>Test Header</h1>';
        $bodyContent = '<p>Test Body</p>';
        $footerContent = '<footer>Test Footer</footer>';

        $this->view->setHeader($headerContent);
        $this->view->setBody($bodyContent);
        $this->view->setFooter($footerContent);

        $this->assertEquals($headerContent, $this->view->getHeader());
        $this->assertEquals($bodyContent, $this->view->getBody());
        $this->assertEquals($footerContent, $this->view->getFooter());
    }

    protected function tearDown(): void
    {
        unset($this->view);
    }
}
