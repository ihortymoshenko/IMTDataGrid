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

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

use IMT\DataGrid\DataSource\Doctrine\ORM\DataSource;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class DataSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataSource
     */
    private $dataSource;

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager
            ->expects($this->any())
            ->method('createQuery')
            ->will($this->returnValue(new Query($entityManager)));

        $this->queryBuilder = new QueryBuilder($entityManager);

        $this->dataSource = new DataSource($this->queryBuilder);
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\DataSource::__construct
     */
    public function testConstructedWithDependencies()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\ORM\QueryBuilder',
            'queryBuilder',
            $this->dataSource
        );
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\DataSource::bindRequest
     */
    public function testBindSortableRequest()
    {
        $request = $this->getRequestMock();
        $request
            ->expects($this->any())
            ->method('getOrder')
            ->will($this->returnValue('ASC'));
        $request
            ->expects($this->any())
            ->method('getSort')
            ->will($this->returnValue('id'));

        $this->dataSource->bindRequest($request);
        
        $dqlPart = $this->queryBuilder->getDQLPart('orderBy');

        $this->assertEquals('id ASC', (string) $dqlPart[0]);
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\DataSource::bindRequest
     */
    public function testBindPageableRequestWithOnePage()
    {
        $request = $this->getRequestMock();
        $request
            ->expects($this->exactly(2))
            ->method('getLimit')
            ->will($this->returnValue(10));
        $request
            ->expects($this->once())
            ->method('getPage')
            ->will($this->returnValue(1));

        $this->dataSource->bindRequest($request);

        $this->assertEquals(0, $this->queryBuilder->getFirstResult());
        $this->assertEquals(10, $this->queryBuilder->getMaxResults());
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\DataSource::bindRequest
     */
    public function testBindPageableRequest()
    {
        $request = $this->getRequestMock();
        $request
            ->expects($this->exactly(2))
            ->method('getLimit')
            ->will($this->returnValue(20));
        $request
            ->expects($this->once())
            ->method('getPage')
            ->will($this->returnValue(3));

        $this->dataSource->bindRequest($request);

        $this->assertEquals(40, $this->queryBuilder->getFirstResult());
        $this->assertEquals(20, $this->queryBuilder->getMaxResults());
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\DataSource::getFilterReflection
     */
    public function testGetFilterReflection()
    {
        $this->assertInstanceOf(
            'IMT\DataGrid\Filter\Reflection\ReflectionInterface',
            $this->dataSource->getFilterReflection()
        );
    }

    /**
     * @covers IMT\DataGrid\DataSource\Doctrine\ORM\DataSource::getPageableResult
     */
    public function testGetPageableResult()
    {
        $this->assertInstanceOf(
            'IMT\DataGrid\DataSource\PageableResultInterface',
            $this->dataSource->getPageableResult()
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getRequestMock()
    {
        return $this->getMock('IMT\DataGrid\HttpFoundation\RequestInterface');
    }
}
