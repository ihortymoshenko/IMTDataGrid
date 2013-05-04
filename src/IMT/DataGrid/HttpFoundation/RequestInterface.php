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

use IMT\DataGrid\Filter\FilterInterface;

/**
 * The interface for the data grid request
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface RequestInterface
{
    /**
     * Gets the filters
     *
     * @return null|FilterInterface Returns null if there are no filters or the
     *                              filters
     */
    public function getFilters();

    /**
     * Gets the number of rows to return from the beginning of the result set
     *
     * @return integer Returns 0 if nothing is passed or the number of rows to
     *                 return from the beginning of the result set
     */
    public function getLimit();

    /**
     * Gets the field name by which need order the result set
     *
     * @return null|string Returns null if nothing is passed or the field name
     *                     by which need order the result set
     */
    public function getOrder();

    /**
     * Gets the page number
     *
     * @return integer Returns 0 if nothing is passed or the page number
     */
    public function getPage();

    /**
     * Gets the value of the sort
     *
     * @return null|string Returns null if nothing is passed or the value of the
     *                     sort
     */
    public function getSort();

    /**
     * Checks whether the request is for filter the grid
     *
     * @return boolean Returns false if nothing is passed
     */
    public function isSearch();
}
