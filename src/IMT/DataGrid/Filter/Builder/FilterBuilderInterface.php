<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter\Builder;

use IMT\DataGrid\Filter\FilterInterface;

/**
 * The interface for the data grid filter builder
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface FilterBuilderInterface
{
    /**
     * Builds the data grid filter by the given array of data
     *
     * @param  array           $data An array of data
     * @return FilterInterface
     */
    public function build(array $data);
}
