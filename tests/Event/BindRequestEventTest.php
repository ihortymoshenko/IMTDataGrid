<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\DataSource\Doctrine\ORM;

use IMT\DataGrid\Event\BindRequestEvent;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class BindRequestEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BindRequestEvent
     */
    private $event;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $dataGrid = $this->getMock('IMT\DataGrid\DataGridInterface');

        $this->event = new BindRequestEvent($dataGrid, $this->getRequestMock());
    }

    /**
     * @covers IMT\DataGrid\Event\BindRequestEvent::__construct
     */
    public function testConstructedWithDependencies()
    {
        $this->assertAttributeInstanceOf(
            'IMT\DataGrid\DataGridInterface',
            'dataGrid',
            $this->event
        );
        $this->assertAttributeInstanceOf(
            'IMT\DataGrid\HttpFoundation\RequestInterface',
            'request',
            $this->event
        );
    }

    /**
     * @covers IMT\DataGrid\Event\BindRequestEvent::getDataGrid
     */
    public function testGetDataGrid()
    {
        $this->assertInstanceOf(
            'IMT\DataGrid\DataGridInterface',
            $this->event->getDataGrid()
        );
    }

    /**
     * @covers IMT\DataGrid\Event\BindRequestEvent::getRequest
     */
    public function testGetRequest()
    {
        $this->assertInstanceOf(
            'IMT\DataGrid\HttpFoundation\RequestInterface',
            $this->event->getRequest()
        );
    }

    /**
     * @covers IMT\DataGrid\Event\BindRequestEvent::getRequest
     * @covers IMT\DataGrid\Event\BindRequestEvent::setRequest
     */
    public function testSetAndGetRequest()
    {
        $request = $this->getRequestMock();

        $returnStatement = $this->event->setRequest($request);

        $this->assertSame($this->event, $returnStatement);
        $this->assertSame($request, $this->event->getRequest());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getRequestMock()
    {
        return $this->getMock('IMT\DataGrid\HttpFoundation\RequestInterface');
    }
}
