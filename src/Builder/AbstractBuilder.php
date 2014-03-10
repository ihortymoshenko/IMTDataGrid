<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Builder;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Templating\EngineInterface;

use IMT\DataGrid\DataGrid;
use IMT\DataGrid\DataGridInterface;

/**
 * The base class for the data grid builder
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
abstract class AbstractBuilder
{
    /**
     * @var DataGridInterface
     */
    protected $dataGrid;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * Builds the data grid columns
     */
    abstract public function buildColumns();

    /**
     * Builds the data source
     */
    abstract public function buildDataSource();

    /**
     * Builds the data grid options
     */
    abstract public function buildOptions();

    /**
     * Creates the data grid
     */
    public function createDataGrid()
    {
        $this->dataGrid = new DataGrid(
            $this->eventDispatcher,
            $this->templating
        );
    }

    /**
     * Gets the data grid
     *
     * @return DataGridInterface
     */
    public function getDataGrid()
    {
        return $this->dataGrid;
    }

    /**
     * Sets the given event dispatcher
     *
     * @param  EventDispatcherInterface $eventDispatcher
     * @return AbstractBuilder
     */
    public function setEventDispatcher(
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * Sets the given templating engine
     *
     * @param  EngineInterface $templating
     * @return AbstractBuilder
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;

        return $this;
    }
}
