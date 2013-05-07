<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\View;

/**
 * The interface for the data grid view
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface ViewInterface
{
    /**
     * @see IMT\DataGrid\DataGridInterface::getColumns()
     */
    public function getColumns();

    /**
     * @see IMT\DataGrid\DataGridInterface::getOptions()
     */
    public function getOptions();

    /**
     * @see IMT\DataGrid\DataGridInterface::getName()
     */
    public function getName();
}
