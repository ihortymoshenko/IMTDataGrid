<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\Column;

use IMT\DataGrid\Column\Column;
use IMT\DataGrid\Column\ColumnInterface;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class ColumnTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers IMT\DataGrid\Column\Column::__construct
     */
    public function testConstructedWithoutRequiredOptions()
    {
        $this
            ->setExpectedException(
                'IMT\DataGrid\Exception\InvalidOptionsException'
            );

        new Column(array());
    }

    /**
     * @covers IMT\DataGrid\Column\Column::get
     */
    public function testGet()
    {
        $column = $this->getColumn();

        $this->assertEquals('index', $column->get('index'));
        $this->assertEquals('label', $column->get('label'));
        $this->assertEquals('name', $column->get('name'));
    }

    /**
     * @covers IMT\DataGrid\Column\Column::has
     */
    public function testHas()
    {
        $column = $this->getColumn();

        $this->assertFalse($column->has('non-existing option'));
        $this->assertTrue($column->has('index'));
        $this->assertTrue($column->has('label'));
        $this->assertTrue($column->has('name'));
    }

    /**
     * @covers IMT\DataGrid\Column\Column::toArray
     */
    public function testToArray()
    {
        $column = $this->getColumn();

        $this->assertEquals(
            array(
                'index' => 'index',
                'label' => 'label',
                'name'  => 'name',
            ),
            $column->toArray()
        );
    }

    /**
     * @return ColumnInterface
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
