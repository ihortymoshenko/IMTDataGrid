<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\Builder;

use IMT\DataGrid\Manager\Manager;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $eventDispatcher = $this
            ->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $templating = $this
            ->getMock('Symfony\Component\Templating\EngineInterface');

        $this->manager = new Manager($eventDispatcher, $templating);
    }

    /**
     * @covers IMT\DataGrid\Manager\Manager::__construct
     */
    public function testConstructedWithDependencies()
    {
        $this->assertAttributeInstanceOf(
            'Symfony\Component\Templating\EngineInterface',
            'templating',
            $this->manager
        );
    }

    /**
     * @covers IMT\DataGrid\Manager\Manager::buildDataGrid
     */
    public function testBuildDataGridWithoutSpecifiedBuilder()
    {
        $this->setExpectedException('IMT\DataGrid\Manager\Exception\DataGridBuilderNotSetException');

        $this->manager->buildDataGrid();
    }

    /**
     * @covers IMT\DataGrid\Manager\Manager::getDataGrid
     */
    public function testGetDataGridWithoutSpecifiedBuilder()
    {
        $this->setExpectedException('IMT\DataGrid\Manager\Exception\DataGridBuilderNotSetException');

        $this->manager->getDataGrid();
    }

    /**
     * @covers IMT\DataGrid\Manager\Manager::buildDataGrid
     * @covers IMT\DataGrid\Manager\Manager::getDataGrid
     */
    public function testBuildAndGetDataGrid()
    {
        $this->manager->setBuilder($this->getBuilderMock());

        $returnStatement = $this->manager->buildDataGrid();

        $this->assertSame($this->manager, $returnStatement);
        $this->assertInstanceOf(
            'IMT\DataGrid\DataGridInterface',
            $this->manager->getDataGrid()
        );
    }

    /**
     * @covers IMT\DataGrid\Manager\Manager::setBuilder
     */
    public function testSetBuilder()
    {
        $returnStatement = $this->manager->setBuilder($this->getBuilderMock());

        $this->assertSame($this->manager, $returnStatement);
        $this->assertAttributeInstanceOf(
            'IMT\DataGrid\Builder\AbstractBuilder',
            'builder',
            $this->manager
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getBuilderMock()
    {
        $builder = $this
            ->getMockForAbstractClass('IMT\DataGrid\Builder\AbstractBuilder');

        $dataGrid = $this->getMock('IMT\DataGrid\DataGridInterface');

        $builder
            ->expects($this->any())
            ->method('createDataGrid')
            ->will($this->returnValue($dataGrid));

        return $builder;
    }
}
