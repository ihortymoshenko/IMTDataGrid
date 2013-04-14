<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Column;

/**
 * The interface for the grid column
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface ColumnInterface
{
    /**
     * Returns the value of the specified option
     *
     * @param  string $option The option name
     * @return mixed          The option value
     */
    public function getOption($option);

    /**
     * Checks whether the grid column has the specified option
     *
     * @param  string  $option The option name
     * @return boolean         Returns false on failure or true on success
     */
    public function hasOption($option);
}
