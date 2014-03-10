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

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class ColumnTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers IMT\DataGrid\Column\Column::__construct
     * @covers IMT\DataGrid\Column\Column::loadValidatorMetadata
     */
    public function testConstructedWithoutRequiredOptions()
    {
        $this->setExpectedException('IMT\DataGrid\Exception\InvalidOptionsException');

        $this->getColumn(array());
    }

    /**
     * @covers IMT\DataGrid\Column\Column::__construct
     * @covers IMT\DataGrid\Column\Column::loadValidatorMetadata
     * @covers IMT\DataGrid\Column\Column::toArray
     */
    public function testConstructedWithExtraOption()
    {
        $options = array(
            'index'  => 'index',
            'label'  => 'label',
            'name'   => 'name',
            'option' => 'option',
        );

        $column = $this->getColumn($options);

        $this->assertSame($options, $column->toArray());
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
     * @param  array  $options
     * @return Column
     */
    private function getColumn(
        array $options = array(
        'index' => 'index',
        'label' => 'label',
        'name'  => 'name'
        )
    ) {
        return new Column($options);
    }
}
