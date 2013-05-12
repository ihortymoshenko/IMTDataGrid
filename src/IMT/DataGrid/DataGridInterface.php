<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid;

use IMT\DataGrid\Column\ColumnCollectionInterface;
use IMT\DataGrid\Column\ColumnInterface;
use IMT\DataGrid\DataSource\DataSourceInterface;
use IMT\DataGrid\Exception\DataSourceNotSetException;
use IMT\DataGrid\HttpFoundation\RequestInterface;
use IMT\DataGrid\View\ViewInterface;

/**
 * The interface for the data grid
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface DataGridInterface
{
    /**
     * Adds the given column
     *
     * @param  ColumnInterface   $column
     * @return DataGridInterface
     */
    public function addColumn(ColumnInterface $column);

    /**
     * Adds the given column at the specified position. Shifts the column
     * currently at that position (if any) and any subsequent columns to the
     * right (adds one to their indices)
     *
     * @param  ColumnInterface   $column
     * @param  integer           $index  The index at which the given column is
     *                                   to be added
     * @return DataGridInterface
     */
    public function addColumnAt(ColumnInterface $column, $index);

    /**
     * Binds the given request
     *
     * @param  RequestInterface          $request
     * @return DataGridInterface
     * @throws DataSourceNotSetException          If the data source is not set
     */
    public function bindRequest(RequestInterface $request);

    /**
     * Creates the data grid view
     *
     * @return ViewInterface
     */
    public function createView();

    /**
     * Gets a collection of objects of type ColumnCollectionInterface
     *
     * @return ColumnCollectionInterface
     */
    public function getColumns();

    /**
     * Gets an array of data
     *
     * @param  boolean                   $distinctResults If set, distinct
     *                                                    results will be
     *                                                    returned. By default,
     *                                                    true
     * @return array
     * @throws DataSourceNotSetException                  If the data source is
     *                                                    not set
     */
    public function getData($distinctResults = true);

    /**
     * Gets the data source
     *
     * @return DataSourceInterface
     */
    public function getDataSource();

    /**
     * Gets the data grid name
     *
     * @return string
     */
    public function getName();

    /**
     * Gets an array of options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Sets the given data source
     *
     * @param  DataSourceInterface $dataSource
     * @return DataGridInterface
     */
    public function setDataSource(DataSourceInterface $dataSource);

    /**
     * Sets the data grid name
     *
     * @param  string            $name The data grid name
     * @return DataGridInterface
     */
    public function setName($name);

    /**
     * Sets an array of options
     *
     * @param  array             $options An array of options
     * @return DataGridInterface
     */
    public function setOptions(array $options);
}
