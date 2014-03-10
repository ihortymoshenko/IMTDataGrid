<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter;

/**
 * The interface for the data grid filter
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
interface FilterInterface
{
    /**
     * Adds the given data grid filter
     *
     * @param  FilterInterface $filter
     * @return FilterInterface
     */
    public function addFilter(FilterInterface $filter);

    /**
     * Adds the given data grid filter rule
     *
     * @param  RuleInterface   $rule
     * @return FilterInterface
     */
    public function addRule(RuleInterface $rule);

    /**
     * Gets an array of objects of type FilterInterface
     *
     * @return FilterInterface[]
     */
    public function getFilters();

    /**
     * Gets the logical operator
     *
     * @return string
     */
    public function getOperator();

    /**
     * Gets an array of objects of type RuleInterface
     *
     * @return RuleInterface[]
     */
    public function getRules();
}
