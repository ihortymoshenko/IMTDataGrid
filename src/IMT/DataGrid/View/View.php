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

use Doctrine\Common\Collections\ArrayCollection;

use IMT\DataGrid\Column\ColumnInterface;

/**
 * This class represents the data grid view
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class View implements ViewInterface
{
    /**
     * @see IMT\DataGrid\DataGridInterface::$columns
     */
    protected $columns;

    /**
     * @see IMT\DataGrid\DataGridInterface::$options
     */
    protected $options;

    /**
     * @see IMT\DataGrid\DataGridInterface::$name
     */
    protected $name;

    /**
     * The constructor method
     */
    public function __construct($name, array $options, ArrayCollection $columns)
    {
        $this->name    = $name;
        $this->options = $options;
        $this->columns = $columns;
    }

    /**
     * {@inheritDoc}
     */
    public function getColModel()
    {
        return $this->columns;
    }

    /**
     * {@inheritDoc}
     */
    public function getColNames()
    {
        $colNames = array();

        /**
         * @var $column ColumnInterface
         */
        foreach ($this->columns as $column) {
            $colNames[] = $column->get('label');
        }

        return $colNames;
    }

    /**
     * {@inheritDoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }
}
