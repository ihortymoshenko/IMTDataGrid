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

use IMT\DataGrid\Filter\GroupInterface;

/**
 * The interface for the grid filter builder
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface FilterBuilderInterface
{
    /**
     * Builds the grid filter by the given array of data
     *
     * @param  array          $data An array of data
     * @return GroupInterface
     */
    public function build(array $data);
}
