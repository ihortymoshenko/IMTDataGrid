<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Event;

use IMT\DataGrid\DataGridInterface;

/**
 * The interface for the data grid event
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface EventInterface
{
    /**
     * Gets the data grid
     *
     * @return DataGridInterface
     */
    public function getDataGrid();
}
