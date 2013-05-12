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
 * This class represents the data grid column collection
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class ColumnCollection implements ColumnCollectionInterface
{
    /**
     * An array of columns
     *
     * @var array
     */
    protected $columns = array();

    /**
     * {@inheritDoc}
     */
    public function add(ColumnInterface $column)
    {
        $this->columns[] = $column;

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function addAt(ColumnInterface $column, $index)
    {
        $this->validateIndex($index);

        $this->columns = array_merge(
            array_slice($this->columns, 0, $index),
            array($column),
            array_slice($this->columns, $index)
        );

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->columns);
    }

    /**
     * {@inheritDoc}
     */
    public function get($index)
    {
        $this->validateIndex($index);

        return $this->columns[$index];
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->columns);
    }

    /**
     * {@inheritDoc}
     */
    public function removeAt($index)
    {
        $this->validateIndex($index);

        $column = $this->columns[$index];

        unset($this->columns[$index]);

        $this->columns = array_values($this->columns);

        return $column;
    }

    /**
     * Validates the given index
     *
     * @param  integer              $index The index to be validated
     * @throws \OutOfRangeException        If the given index is out of range
     */
    private function validateIndex($index)
    {
        if ($index < 0 || $index >= $this->count()) {
            throw new \OutOfRangeException(
                'The specified index is out of range.'
            );
        }
    }
}