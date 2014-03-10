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

use IMT\DataGrid\Filter\Builder\Builder;

/**
 * This class represents the data grid request for jqGrid
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @link http://www.trirand.com/jqgridwiki/doku.php?id=wiki:advanced_searching
 */
class JqGridRequest implements RequestInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * The constructor method
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        $filters = json_decode($this->request->get('filters'), true);

        return !is_array($filters) || count($filters) < 1
            ? null
            : $this->getFilterBuilder()->build($filters);
    }

    /**
     * {@inheritDoc}
     */
    public function getLimit()
    {
        return $this->request->get('rows', 0);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return $this->request->get('sord', null);
    }

    /**
     * {@inheritDoc}
     */
    public function getPage()
    {
        return $this->request->get('page', 0);
    }

    /**
     * {@inheritDoc}
     */
    public function getSort()
    {
        return $this->request->get('sidx', null);
    }

    /**
     * {@inheritDoc}
     */
    public function isSearch()
    {
        return $this->request->get('_search', false);
    }

    /**
     * Gets the data grid filter builder
     *
     * @return Builder
     */
    protected function getFilterBuilder()
    {
        return new Builder();
    }
}
