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
use IMT\DataGrid\DataGrid;
use IMT\DataGrid\DataGridInterface;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class DataGridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataGridInterface
     */
    private $dataGrid;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $templating = $this
            ->getMock('Symfony\Component\Templating\EngineInterface');

        $this->dataGrid = new DataGrid($templating);
    }

    /**
     * @covers IMT\DataGrid\DataGrid::__construct
     */
    public function testConstructedWithDependencies()
    {
        $this->assertAttributeInstanceOf(
            'Symfony\Component\Templating\EngineInterface',
            'templating',
            $this->dataGrid
        );
    }

    /**
     * @covers IMT\DataGrid\DataGrid::__construct
     * @covers IMT\DataGrid\DataGrid::getColumns
     */
    public function testConstructedWithoutColumns()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            'columns',
            $this->dataGrid
        );
        $this->assertCount(0, $this->dataGrid->getColumns());
    }

    /**
     * @covers IMT\DataGrid\DataGrid::getOptions
     */
    public function testConstructedWithoutOptions()
    {
        $this->assertCount(0, $this->dataGrid->getOptions());
    }

    /**
     * @covers IMT\DataGrid\DataGrid::addColumn
     * @covers IMT\DataGrid\DataGrid::getColumns
     */
    public function testAddAndGetColumns()
    {
        $column = new Column(
            array(
                'index' => 'index',
                'label' => 'label',
                'name'  => 'name',
            )
        );

        $returnStatement = $this->dataGrid->addColumn($column);

        $this->assertSame($this->dataGrid, $returnStatement);
        $this->assertCount(1, $this->dataGrid->getColumns());
        $this->assertSame($column, $this->dataGrid->getColumns()->get('name'));
    }

    /**
     * @covers IMT\DataGrid\DataGrid::bindRequest
     */
    public function testBindRequestWithoutSpecifiedDataSource()
    {
        $request = $this
            ->getMock('IMT\DataGrid\HttpFoundation\RequestInterface');

        $this->setExpectedException(
            'IMT\DataGrid\Exception\DataSourceNotSetException'
        );

        $this->dataGrid->bindRequest($request);
    }

    /**
     * @covers IMT\DataGrid\DataGrid::bindRequest
     * @covers IMT\DataGrid\DataGrid::setDataSource
     */
    public function testBindRequest()
    {
        $this->dataGrid->setDataSource($this->getDataSourceMock());

        $request = $this
            ->getMock('IMT\DataGrid\HttpFoundation\RequestInterface');

        $returnStatement = $this->dataGrid->bindRequest($request);

        $this->assertSame($this->dataGrid, $returnStatement);
    }

    /**
     * @covers IMT\DataGrid\DataGrid::createView
     */
    public function testCreateView()
    {
        $this->assertInstanceOf(
            'IMT\DataGrid\View\ViewInterface',
            $this->dataGrid->createView()
        );
    }

    /**
     * @covers IMT\DataGrid\DataGrid::getData
     */
    public function testGetDataWithoutSpecifiedDataSource()
    {
        $this->setExpectedException(
            'IMT\DataGrid\Exception\DataSourceNotSetException'
        );

        $this->dataGrid->getData();
    }

    /**
     * @covers IMT\DataGrid\DataGrid::setDataSource
     */
    public function testSetDataSource()
    {
        $returnStatement = $this
            ->dataGrid
            ->setDataSource($this->getDataSourceMock());

        $this->assertAttributeInstanceOf(
            'IMT\DataGrid\DataSource\DataSourceInterface',
            'dataSource',
            $this->dataGrid
        );
        $this->assertSame($this->dataGrid, $returnStatement);
    }

    /**
     * @covers IMT\DataGrid\DataGrid::getName
     * @covers IMT\DataGrid\DataGrid::setName
     */
    public function testSetAndGetName()
    {
        $name = 'Grid';

        $dataGrid = $this->dataGrid->setName($name);

        $this->assertSame($this->dataGrid, $dataGrid);
        $this->assertEquals($name, $this->dataGrid->getName());
    }

    /**
     * @covers IMT\DataGrid\DataGrid::getOptions
     * @covers IMT\DataGrid\DataGrid::setOptions
     */
    public function testSetAndGetOptions()
    {
        $options = array(
            'option1' => 'value1',
            'option2' => 'value2',
            'option3' => 'value3',
        );

        $this->dataGrid->setOptions($options);

        $this->assertEquals($options, $this->dataGrid->getOptions());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getDataSourceMock()
    {
        return $this->getMock('IMT\DataGrid\DataSource\DataSourceInterface');
    }
}
