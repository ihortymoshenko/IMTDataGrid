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

use IMT\DataGrid\Registry\Exception\GridNotFoundException;
use IMT\DataGrid\GridInterface;

/**
 * The interface for the grid registry
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface RegistryInterface
{
    /**
     * Adds the given grid
     *
     * @param  GridInterface     $grid
     * @param  null|string       $alias The grid alias. If set, will be used as
     *                                  the grid name
     * @return RegistryInterface
     */
    public function add(GridInterface $grid, $alias = null);

    /**
     * Gets the grid by the specified grid name
     *
     * @param  string                $name The grid name
     * @return GridInterface
     * @throws GridNotFoundException       If the requested grid was not found
     */
    public function get($name);
}
