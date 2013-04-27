<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\Factory;

use IMT\DataGrid\Factory\Factory;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->factory = new Factory(
            $this->getRegistryMock(),
            $this->getTemplatingMock()
        );
    }

    /**
     * @covers IMT\DataGrid\Factory\Factory::__construct
     */
    public function testConstructedWithDependencies()
    {
        $this->assertAttributeInstanceOf(
            'IMT\DataGrid\Registry\RegistryInterface',
            'registry',
            $this->factory
        );
        $this->assertAttributeInstanceOf(
            'Symfony\Component\Templating\EngineInterface',
            'templating',
            $this->factory
        );
    }

    /**
     * @covers IMT\DataGrid\Factory\Factory::create
     */
    public function testCreate()
    {
        $this->assertInstanceOf(
            'IMT\DataGrid\DataGridInterface',
            $this->factory->create()
        );
    }

    /**
     * @covers IMT\DataGrid\Factory\Factory::createNamed
     */
    public function testCreateNamed()
    {
        $dataGrid = $this->getMock('IMT\DataGrid\DataGridInterface');

        $registry = $this->getRegistryMock();
        $registry
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo('name'))
            ->will($this->returnValue($dataGrid));

        $factory = new Factory($registry, $this->getTemplatingMock());

        $this->assertInstanceOf(
            'IMT\DataGrid\DataGridInterface',
            $factory->createNamed('name')
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getRegistryMock()
    {
        return $this->getMock('IMT\DataGrid\Registry\RegistryInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getTemplatingMock()
    {
        return $this->getMock('Symfony\Component\Templating\EngineInterface');
    }
}
