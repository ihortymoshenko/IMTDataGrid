<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\HttpFoundation;

use Symfony\Component\HttpFoundation\Request;

use IMT\DataGrid\HttpFoundation\JqGridRequest;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class JqGridRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JqGridRequest
     */
    private $jqGridRequest;

    /**
     * @var Request
     */
    private $request;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->request       = new Request();
        $this->jqGridRequest = new JqGridRequest($this->request);
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::__construct
     */
    public function testConstruct()
    {
        $this->assertAttributeInstanceOf(
            'Symfony\Component\HttpFoundation\Request',
            'request',
            $this->jqGridRequest
        );
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getFilters
     */
    public function testGetFiltersReturnsNullArrayByDefault()
    {
        $this->assertNull($this->jqGridRequest->getFilters());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getLimit
     */
    public function testGetLimitReturnsZeroByDefault()
    {
        $this->assertEquals(0, $this->jqGridRequest->getLimit());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getLimit
     */
    public function testGetLimitReturnsSpecifiedValue()
    {
        $limit = 123;

        $this->request->request->set('rows', $limit);

        $this->assertEquals($limit, $this->jqGridRequest->getLimit());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getOrder
     */
    public function testGetOrderReturnsNullByDefault()
    {
        $this->assertNull($this->jqGridRequest->getOrder());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getOrder
     */
    public function testGetOrderReturnsSpecifiedValue()
    {
        $order = 'ASC';

        $this->request->request->set('sord', $order);

        $this->assertEquals($order, $this->jqGridRequest->getOrder());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getPage
     */
    public function testGetPageReturnsZeroByDefault()
    {
        $this->assertEquals(0, $this->jqGridRequest->getPage());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getPage
     */
    public function testGetPageReturnsSpecifiedValue()
    {
        $page = 1;

        $this->request->request->set('page', $page);

        $this->assertEquals($page, $this->jqGridRequest->getPage());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getSort
     */
    public function testGetSortReturnsNullByDefault()
    {
        $this->assertNull($this->jqGridRequest->getSort());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::getSort
     */
    public function testGetSortReturnsSpecifiedValue()
    {
        $sort = 'field';

        $this->request->request->set('sidx', $sort);

        $this->assertEquals($sort, $this->jqGridRequest->getSort());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::isSearch
     */
    public function testIsSearchReturnsFalseByDefault()
    {
        $this->assertFalse($this->jqGridRequest->isSearch());
    }

    /**
     * @covers IMT\DataGrid\HttpFoundation\JqGridRequest::isSearch
     */
    public function testIsSearchReturnsSpecifiedValue()
    {
        $isSearch = true;

        $this->request->request->set('_search', $isSearch);

        $this->assertEquals($isSearch, $this->jqGridRequest->isSearch());
    }
}
