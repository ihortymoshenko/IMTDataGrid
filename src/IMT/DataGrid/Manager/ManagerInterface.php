<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Manager;

use IMT\DataGrid\Builder\AbstractBuilder;
use IMT\DataGrid\Manager\Exception\DataGridBuilderNotSetException;

/**
 * The interface for the data grid manager
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface ManagerInterface
{
    /**
     * Builds the data grid
     *
     * @return ManagerInterface
     * @throws DataGridBuilderNotSetException If the data grid builder is not
     *                                        set
     */
    public function buildDataGrid();

    /**
     * @see IMT\DataGrid\Builder\AbstractBuilder::getDataGrid()
     * @throws DataGridBuilderNotSetException If the data grid builder is not
     *                                        set
     */
    public function getDataGrid();

    /**
     * Sets the given data grid builder
     *
     * @param  AbstractBuilder  $builder
     * @return ManagerInterface
     */
    public function setBuilder(AbstractBuilder $builder);
}
