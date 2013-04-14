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
 * This class represents the grid registry
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
    protected $grids = array();

    /**
     * {@inheritDoc}
     */
    public function add(GridInterface $grid, $alias = null)
    {
        $this->grids[!isset($alias) ? $grid->getName() : $alias] = $grid;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get($name)
    {
        if (!isset($this->grids[$name])) {
            throw new GridNotFoundException(
                sprintf('The grid named `%s` was not found.', $name)
            );
        }

        return $this->grids[$name];
    }
}
