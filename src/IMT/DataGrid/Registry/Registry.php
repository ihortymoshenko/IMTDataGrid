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
 * This class represents the data grid registry
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Registry implements RegistryInterface
{
    /**
     * An array of objects of type GridInterface
     *
     * @var array
     */
    protected $dataGrids = array();

    /**
     * {@inheritDoc}
     */
    public function add(DataGridInterface $dataGrid, $alias = null)
    {
        $name = !isset($alias) ? $dataGrid->getName() : $alias;

        $this->dataGrids[$name] = $dataGrid;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get($name)
    {
        if (!isset($this->dataGrids[$name])) {
            throw new DataGridNotFoundException(
                sprintf('The data grid named `%s` was not found.', $name)
            );
        }

        return $this->dataGrids[$name];
    }
}
