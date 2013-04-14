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
     */
    public function testConstructedWithoutRequiredOptionIndex()
    {
        $this->setExpectedException(
            'Symfony\Component\OptionsResolver\Exception\MissingOptionsException'
        );

        new Column(array('name' => 'name'));
    }

    /**
     * @covers IMT\DataGrid\Column\Column::__construct
     */
    public function testConstructedWithoutRequiredOptionName()
    {
        $this->setExpectedException(
            'Symfony\Component\OptionsResolver\Exception\MissingOptionsException'
        );

        new Column(array('index' => 'index'));
    }

    /**
     * @covers IMT\DataGrid\Column\Column::getOption
     */
    public function testGetOption()
    {
        $column = new Column(array('index' => 'index', 'name' => 'name'));

        $this->assertEquals('index', $column->getOption('index'));
        $this->assertEquals('name', $column->getOption('name'));
    }

    /**
     * @covers IMT\DataGrid\Column\Column::hasOption
     */
    public function testHasOption()
    {
        $column = new Column(array('index' => 'index', 'name' => 'name'));

        $this->assertFalse($column->hasOption('non-existing option'));
        $this->assertTrue($column->hasOption('index'));
        $this->assertTrue($column->hasOption('name'));
    }
}
