<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Factory;

use IMT\DataGrid\DataGridInterface;

/**
 * The interface for the data grid factory
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface FactoryInterface
{
    /**
     * Creates the data grid
     *
     * @return DataGridInterface
     */
    public function create();

    /**
     * Creates the data grid using by the specified service name that represents
     * the data grid
     *
     * @param  string            $name The service name that represents the data
     *                                 grid
     * @return DataGridInterface
     */
    public function createNamed($name);
}
