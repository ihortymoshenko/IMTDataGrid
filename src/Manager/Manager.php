<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Templating\EngineInterface;

use IMT\DataGrid\Builder\AbstractBuilder;
use IMT\DataGrid\Manager\Exception\DataGridBuilderNotSetException;

/**
 * This class represents the data grid manager
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Manager implements ManagerInterface
{
    /**
     * @var AbstractBuilder
     */
    protected $builder;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * The constructor method
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param EngineInterface          $templating
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        EngineInterface $templating
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->templating      = $templating;
    }

    /**
     * {@inheritDoc}
     */
    public function buildDataGrid()
    {
        if ($this->builder === null) {
            throw new DataGridBuilderNotSetException();
        }

        $this
            ->builder
            ->setEventDispatcher($this->eventDispatcher)
            ->setTemplating($this->templating)
            ->createDataGrid();

        $this->builder->buildColumns();
        $this->builder->buildDataSource();
        $this->builder->buildOptions();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataGrid()
    {
        if ($this->builder === null) {
            throw new DataGridBuilderNotSetException();
        }

        return $this->builder->getDataGrid();
    }

    /**
     * {@inheritDoc}
     */
    public function setBuilder(AbstractBuilder $builder)
    {
        $this->builder = $builder;

        return $this;
    }
}
