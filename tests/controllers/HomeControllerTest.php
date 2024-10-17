<?php

declare(strict_types=1);

namespace Tests\Controllers;

use Controllers\HomeController;
use PHPUnit\Framework\TestCase;
use Help\BaseView;

class HomeControllerTest extends TestCase
{
    public function testHomeSetsTitleAndFolder(): void
    {
        $baseViewMock = $this->getMockBuilder(BaseView::class)
            ->disableOriginalConstructor()
            ->getMock();

        $baseViewMock->expects($this->once())
            ->method('setTitle');
        $baseViewMock->setTitle('title');

        $baseViewMock->expects($this->once())
            ->method('folder');
        $baseViewMock->folder('folder');

        (new HomeController());
    }
}

