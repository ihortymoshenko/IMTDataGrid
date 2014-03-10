<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Builder;

use IMT\DataGrid\Builder\AbstractBuilder;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class AbstractBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractBuilder
     */
    private $abstractBuilder;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->abstractBuilder = $this
            ->getMockForAbstractClass('IMT\DataGrid\Builder\AbstractBuilder');
    }

    /**
     * @covers IMT\DataGrid\Builder\AbstractBuilder::createDataGrid
     * @covers IMT\DataGrid\Builder\AbstractBuilder::getDataGrid
     */
    public function testCreateAndGetDataGrid()
    {
        $this
            ->abstractBuilder
            ->setEventDispatcher($this->getEventDispatcherMock())
            ->setTemplating($this->getTemplatingMock())
            ->createDataGrid();

        $this->assertInstanceOf(
            'IMT\DataGrid\DataGridInterface',
            $this->abstractBuilder->getDataGrid()
        );
    }

    /**
     * @covers IMT\DataGrid\Builder\AbstractBuilder::setEventDispatcher
     */
    public function testSetEventDispatcher()
    {
        $returnStatement = $this
            ->abstractBuilder
            ->setEventDispatcher($this->getEventDispatcherMock());

        $this->assertSame($this->abstractBuilder, $returnStatement);
        $this->assertAttributeInstanceOf(
            'Symfony\Component\EventDispatcher\EventDispatcherInterface',
            'eventDispatcher',
            $this->abstractBuilder
        );
    }

    /**
     * @covers IMT\DataGrid\Builder\AbstractBuilder::setTemplating
     */
    public function testSetTemplating()
    {
        $returnStatement = $this
            ->abstractBuilder
            ->setTemplating($this->getTemplatingMock());

        $this->assertSame($this->abstractBuilder, $returnStatement);
        $this->assertAttributeInstanceOf(
            'Symfony\Component\Templating\EngineInterface',
            'templating',
            $this->abstractBuilder
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getEventDispatcherMock()
    {
        return $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getTemplatingMock()
    {
        return $this->getMock('Symfony\Component\Templating\EngineInterface');
    }
}
