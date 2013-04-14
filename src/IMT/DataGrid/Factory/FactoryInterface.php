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

use IMT\DataGrid\GridInterface;

/**
 * The interface for the grid factory
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface FactoryInterface
{
    /**
     * Creates the grid
     *
     * @return GridInterface
     */
    public function create();

    /**
     * Creates the grid using by the specified name of the service that
     * represents the grid
     *
     * @param  string        $name The name of the service that represents the
     *                             grid
     * @return GridInterface
     */
    public function createNamed($name);
}
