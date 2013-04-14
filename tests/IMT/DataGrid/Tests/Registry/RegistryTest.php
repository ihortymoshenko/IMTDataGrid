<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\View;

use Doctrine\Common\Collections\ArrayCollection;

use IMT\DataGrid\Registry\Registry;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class RegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->registry = new Registry();
    }

    /**
     * @covers IMT\DataGrid\Registry\Registry::add
     * @covers IMT\DataGrid\Registry\Registry::get
     */
    public function testAddGridWithoutAlias()
    {
        $grid = $this->getGridMock();

        $this->registry->add($grid);

        $this->assertSame($grid, $this->registry->get('name'));
        $this->setExpectedException(
            'IMT\DataGrid\Registry\Exception\GridNotFoundException'
        );

        $this->registry->get('alias');
    }

    /**
     * @covers IMT\DataGrid\Registry\Registry::add
     * @covers IMT\DataGrid\Registry\Registry::get
     */
    public function testAddGridWithAlias()
    {
        $grid = $this->getGridMock();

        $this->registry->add($grid, 'alias');

        $this->assertSame($grid, $this->registry->get('alias'));
        $this->setExpectedException(
            'IMT\DataGrid\Registry\Exception\GridNotFoundException'
        );

        $this->registry->get('name');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getGridMock()
    {
        $grid = $this->getMock('IMT\DataGrid\GridInterface');
        $grid
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('name'));

        return $grid;
    }
}
