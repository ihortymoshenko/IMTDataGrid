<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Column;

use IMT\DataGrid\Column\Column;
use IMT\DataGrid\Column\ColumnCollection;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class ColumnCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ColumnCollection
     */
    private $columnCollection;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->columnCollection = new ColumnCollection();
    }

    /**
     * @covers IMT\DataGrid\Column\ColumnCollection::add
     * @covers IMT\DataGrid\Column\ColumnCollection::count
     * @covers IMT\DataGrid\Column\ColumnCollection::get
     */
    public function testAdd()
    {
        $column = $this->getColumn();

        $returnStatement = $this->columnCollection->add($column);

        $this->assertTrue($returnStatement);
        $this->assertCount(1, $this->columnCollection);
        $this->assertSame($column, $this->columnCollection->get(0));
    }

    /**
     * @covers IMT\DataGrid\Column\ColumnCollection::addAt
     */
    public function testAddAtWithInvalidIndex()
    {
        $column = $this->getColumn();

        $this->setExpectedException('OutOfRangeException');

        $this->columnCollection->addAt($column, -1);
        $this->columnCollection->addAt($column, 1);
    }

    /**
     * @covers IMT\DataGrid\Column\ColumnCollection::add
     * @covers IMT\DataGrid\Column\ColumnCollection::addAt
     * @covers IMT\DataGrid\Column\ColumnCollection::count
     * @covers IMT\DataGrid\Column\ColumnCollection::get
     */
    public function testAddAt()
    {
        $column = $this->getColumn();

        $this->columnCollection->add($column);
        $this->columnCollection->add($column);

        $returnStatement = $this
            ->columnCollection
            ->addAt($column, 1);

        $this->assertTrue($returnStatement);
        $this->assertCount(3, $this->columnCollection);
        $this->assertSame($column, $this->columnCollection->get(0));
        $this->assertSame($column, $this->columnCollection->get(1));
        $this->assertSame($column, $this->columnCollection->get(2));
    }

    /**
     * @covers IMT\DataGrid\Column\ColumnCollection::get
     */
    public function testGetWithInvalidIndex()
    {
        $this->setExpectedException('OutOfRangeException');

        $this->columnCollection->get(-1);
        $this->columnCollection->get(1);
    }

    /**
     * @covers IMT\DataGrid\Column\ColumnCollection::getIterator
     */
    public function testGetIterator()
    {
        $this->assertInstanceOf(
            'ArrayIterator',
            $this->columnCollection->getIterator()
        );
    }

    /**
     * @covers IMT\DataGrid\Column\ColumnCollection::removeAt
     */
    public function testRemoveAtWithInvalidIndex()
    {
        $this->setExpectedException('OutOfRangeException');

        $this->columnCollection->removeAt(-1);
        $this->columnCollection->removeAt(1);
    }

    /**
     * @covers IMT\DataGrid\Column\ColumnCollection::add
     * @covers IMT\DataGrid\Column\ColumnCollection::get
     * @covers IMT\DataGrid\Column\ColumnCollection::count
     * @covers IMT\DataGrid\Column\ColumnCollection::removeAt
     */
    public function testRemoveAt()
    {
        $column = $this->getColumn();

        $this->columnCollection->add($column);
        $this->columnCollection->add($column);

        $this->assertCount(2, $this->columnCollection);

        $returnStatement = $this->columnCollection->removeAt(0);

        $this->assertCount(1, $this->columnCollection);
        $this->assertSame($column, $returnStatement);
        $this->assertSame($column, $this->columnCollection->get(0));
    }

    /**
     * @return Column
     */
    private function getColumn()
    {
        return new Column(
            array(
                'index' => 'index',
                'label' => 'label',
                'name'  => 'name',
            )
        );
    }
}
