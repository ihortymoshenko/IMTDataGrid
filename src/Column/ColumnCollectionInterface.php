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
 * The interface for the data grid column collection
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface ColumnCollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * Adds the given column
     *
     * @param  ColumnInterface $column
     * @return boolean                 Returns true if the collection changed as
     *                                 a result of the call
     */
    public function add(ColumnInterface $column);

    /**
     * Adds the given column at the specified position. Shifts the column
     * currently at that position (if any) and any subsequent columns to the
     * right (adds one to their indices)
     *
     * @param  ColumnInterface      $column
     * @param  integer              $index  The index at which the given column
     *                                      is to be added
     * @return boolean                      Returns true if the collection
     *                                      changed as a result of the call
     * @throws \OutOfRangeException         If the specified index is out of
     *                                      range
     */
    public function addAt(ColumnInterface $column, $index);

    /**
     * Gets the column by the specified position
     *
     * @param  integer              $index The index of the column to return
     * @return ColumnInterface
     * @throws \OutOfRangeException        If the specified index is out of
     *                                     range
     */
    public function get($index);

    /**
     * Removes the column at the specified position. Shifts any subsequent
     * columns to the left (subtracts one from their indices)
     *
     * @param  integer              $index The index of the column to be removed
     * @return ColumnInterface             Returns the column previously at the
     *                                     specified position
     * @throws \OutOfRangeException        If the specified index is out of
     *                                     range
     */
    public function removeAt($index);
}
