<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests;

use IMT\DataGrid\Column\Column;
use IMT\DataGrid\Grid;
use IMT\DataGrid\GridInterface;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class GridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GridInterface
     */
    private $grid;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $templating = $this
            ->getMock('Symfony\Component\Templating\EngineInterface');

        $this->grid = new Grid($templating);
    }

    /**
     * @covers IMT\DataGrid\Grid::__construct
     */
    public function testConstructedWithDependencies()
    {
        $this->assertAttributeInstanceOf(
            'Symfony\Component\Templating\EngineInterface',
            'templating',
            $this->grid
        );
    }

    /**
     * @covers IMT\DataGrid\Grid::__construct
     * @covers IMT\DataGrid\Grid::getColumns
     */
    public function testConstructedWithoutColumns()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            'columns',
            $this->grid
        );
        $this->assertCount(0, $this->grid->getColumns());
    }

    /**
     * @covers IMT\DataGrid\Grid::getOptions
     */
    public function testConstructedWithoutOptions()
    {
        $this->assertCount(0, $this->grid->getOptions());
    }

    /**
     * @covers IMT\DataGrid\Grid::addColumn
     * @covers IMT\DataGrid\Grid::getColumns
     */
    public function testAddAndGetColumns()
    {
        $column = new Column(array('index' => 'index', 'name' => 'name'));

        $returnStatement = $this->grid->addColumn($column);

        $this->assertSame($this->grid, $returnStatement);
        $this->assertCount(1, $this->grid->getColumns());
    }

    /**
     * @covers IMT\DataGrid\Grid::bindRequest
     */
    public function testBindRequestWithoutSpecifiedDataSource()
    {
        $request = $this
            ->getMock('IMT\DataGrid\HttpFoundation\RequestInterface');

        $this->setExpectedException(
            'IMT\DataGrid\Exception\DataSourceNotSetException'
        );

        $this->grid->bindRequest($request);
    }

    /**
     * @covers IMT\DataGrid\Grid::bindRequest
     * @covers IMT\DataGrid\Grid::setDataSource
     */
    public function testBindRequest()
    {
        $this->grid->setDataSource($this->getDataSourceMock());

        $request = $this
            ->getMock('IMT\DataGrid\HttpFoundation\RequestInterface');

        $returnStatement = $this->grid->bindRequest($request);

        $this->assertSame($this->grid, $returnStatement);
    }

    /**
     * @covers IMT\DataGrid\Grid::createView
     */
    public function testCreateView()
    {
        $this->assertInstanceOf(
            'IMT\DataGrid\View\ViewInterface',
            $this->grid->createView()
        );
    }

    /**
     * @covers IMT\DataGrid\Grid::getData
     */
    public function testGetDataWithoutSpecifiedDataSource()
    {
        $this->setExpectedException(
            'IMT\DataGrid\Exception\DataSourceNotSetException'
        );

        $this->grid->getData();
    }

    /**
     * @covers IMT\DataGrid\Grid::setDataSource
     */
    public function testSetDataSource()
    {
        $returnStatement = $this
            ->grid
            ->setDataSource($this->getDataSourceMock());

        $this->assertAttributeInstanceOf(
            'IMT\DataGrid\DataSource\DataSourceInterface',
            'dataSource',
            $this->grid
        );
        $this->assertSame($this->grid, $returnStatement);
    }

    /**
     * @covers IMT\DataGrid\Grid::getName
     * @covers IMT\DataGrid\Grid::setName
     */
    public function testSetAndGetName()
    {
        $name = 'Grid';

        $grid = $this->grid->setName($name);

        $this->assertSame($this->grid, $grid);
        $this->assertEquals($name, $this->grid->getName());
    }

    /**
     * @covers IMT\DataGrid\Grid::getOptions
     * @covers IMT\DataGrid\Grid::setOptions
     */
    public function testSetAndGetOptions()
    {
        $options = array(
            'option1' => 'value1',
            'option2' => 'value2',
            'option3' => 'value3',
        );

        $this->grid->setOptions($options);

        $this->assertEquals($options, $this->grid->getOptions());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getDataSourceMock()
    {
        return $this->getMock('IMT\DataGrid\DataSource\DataSourceInterface');
    }
}
