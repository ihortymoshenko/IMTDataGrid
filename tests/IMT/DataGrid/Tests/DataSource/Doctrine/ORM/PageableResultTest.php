<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\DataSource\Doctrine\ORM;

use IMT\DataGrid\DataSource\Doctrine\ORM\PageableResult;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class PageableResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\PageableResult::__construct
     */
    public function testConstructedWithDependencies()
    {
        $pageableResult = new PageableResult($this->getPaginatorMock());

        $this->assertAttributeInstanceOf(
            'Doctrine\ORM\Tools\Pagination\Paginator',
            'paginator',
            $pageableResult
        );
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\PageableResult::getCurrentPage
     */
    public function testGetCurrentPageWhenTotalRowsCountEqualsToOffset()
    {
        $paginator = $this->getPaginatorMock();
        $paginator
            ->expects($this->once())
            ->method('count')
            ->will($this->returnValue(10));
        $paginator
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($this->getQueryBuilderMock()));

        $pageableResult = new PageableResult($paginator);

        $this->assertEquals(1, $pageableResult->getCurrentPage());
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\PageableResult::getCurrentPage
     */
    public function testGetCurrentPage()
    {
        $paginator = $this->getPaginatorMock();
        $paginator
            ->expects($this->once())
            ->method('count')
            ->will($this->returnValue(30));
        $paginator
            ->expects($this->exactly(2))
            ->method('getQuery')
            ->will($this->returnValue($this->getQueryBuilderMock()));

        $pageableResult = new PageableResult($paginator);

        $this->assertEquals(2, $pageableResult->getCurrentPage());
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\PageableResult::getIterator
     */
    public function testGetIterator()
    {
        $paginator = $this->getPaginatorMock();
        $paginator
            ->expects($this->once())
            ->method('getIterator')
            ->will($this->returnValue(new \ArrayIterator()));

        $pageableResult = new PageableResult($paginator);

        $this->assertInstanceOf(
            'ArrayIterator',
            $pageableResult->getIterator()
        );
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\PageableResult::getTotalPagesCount
     */
    public function testGetTotalPagesCountWhenRowsDoesNotExist()
    {
        $paginator = $this->getPaginatorMock();
        $paginator
            ->expects($this->once())
            ->method('count')
            ->will($this->returnValue(0));

        $pageableResult = new PageableResult($paginator);

        $this->assertEquals(1, $pageableResult->getTotalPagesCount());
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\PageableResult::getTotalPagesCount
     */
    public function testGetTotalPagesCount()
    {
        $paginator = $this->getPaginatorMock();
        $paginator
            ->expects($this->exactly(2))
            ->method('count')
            ->will($this->returnValue(20));
        $paginator
            ->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($this->getQueryBuilderMock()));

        $pageableResult = new PageableResult($paginator);

        $this->assertEquals(2, $pageableResult->getTotalPagesCount());
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\PageableResult::getTotalRowsCount
     */
    public function testGetTotalRowsCount()
    {
        $paginator = $this->getPaginatorMock();
        $paginator
            ->expects($this->once())
            ->method('count')
            ->will($this->returnValue(10));

        $pageableResult = new PageableResult($paginator);

        $this->assertEquals(10, $pageableResult->getTotalRowsCount());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getPaginatorMock()
    {
        return $this
            ->getMockBuilder('Doctrine\ORM\Tools\Pagination\Paginator')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getQueryBuilderMock()
    {
        $queryBuilder = $this
            ->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilder
            ->expects($this->any())
            ->method('getFirstResult')
            ->will($this->returnValue(10));
        $queryBuilder
            ->expects($this->any())
            ->method('getMaxResults')
            ->will($this->returnValue(10));

        return $queryBuilder;
    }
}
