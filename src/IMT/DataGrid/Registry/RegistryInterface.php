<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Registry;

use IMT\DataGrid\Registry\Exception\DataGridNotFoundException;
use IMT\DataGrid\DataGridInterface;

/**
 * The interface for the data grid registry
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface RegistryInterface
{
    /**
     * Adds the given data grid
     *
     * @param  DataGridInterface $dataGrid
     * @param  null|string       $alias    The data grid alias. If set, will be
     *                                     used as the data grid name
     * @return RegistryInterface
     */
    public function add(DataGridInterface $dataGrid, $alias = null);

    /**
     * Gets the data grid by the specified data grid name
     *
     * @param  string                    $name The data grid name
     * @return DataGridInterface
     * @throws DataGridNotFoundException       If the requested data grid was
     *                                         not found
     */
    public function get($name);
}
