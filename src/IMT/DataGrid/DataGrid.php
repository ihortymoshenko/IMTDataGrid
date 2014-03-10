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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Templating\EngineInterface;

use IMT\DataGrid\Column\ColumnCollection;
use IMT\DataGrid\Column\ColumnInterface;
use IMT\DataGrid\DataSource\DataSourceInterface;
use IMT\DataGrid\Event\BindRequestEvent;
use IMT\DataGrid\Exception\DataSourceNotSetException;

/**
 * This class represents the data grid
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class DataGrid implements DataGridInterface
{
    /**
     * A collection of objects of type ColumnInterface
     *
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var DataSourceInterface
     */
    protected $dataSource;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * The data grid name
     *
     * @var string
     */
    protected $name;

    /**
     * An array of options
     *
     * @var array
     */
    protected $options = array();

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

        $this->columns = new ColumnCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function addColumn(ColumnInterface $column)
    {
        $this->columns->add($column);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addColumnAt(ColumnInterface $column, $index)
    {
        $this->columns->addAt($column, $index);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function bindRequest(HttpFoundation\RequestInterface $request)
    {
        if ($this->dataSource === null) {
            throw new DataSourceNotSetException();
        }

        $event = new BindRequestEvent($this, $request);
        $this->eventDispatcher->dispatch(
            DataGridEvents::PRE_BIND_REQUEST,
            $event
        );

        $this->dataSource->bindRequest($event->getRequest());

        $this->eventDispatcher->dispatch(
            DataGridEvents::POST_BIND_REQUEST,
            new BindRequestEvent($this, $event->getRequest())
        );

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function createView()
    {
        return new View\View($this->name, $this->options, $this->getColumns());
    }

    /**
     * {@inheritDoc}
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * {@inheritDoc}
     */
    public function getData($distinctResults = true)
    {
        if ($this->dataSource === null) {
            throw new DataSourceNotSetException();
        }

        $pageableResult = $this
            ->dataSource
            ->getPageableResult($distinctResults);

        $data = array(
            'page'    => $pageableResult->getCurrentPage(),
            'records' => $pageableResult->getTotalItemsCount(),
            'rows'    => array(),
            'total'   => $pageableResult->getTotalPagesCount(),
        );

        $keys = array();

        /**
         * @var $column ColumnInterface
         */
        foreach ($this->columns as $column) {
            if (array_key_exists(
                $column->get('name'),
                $pageableResult->getIterator()->current()
            )
            ) {
                $keys[] = $column->get('name');
            }
        }

        foreach ($pageableResult as $id => $row) {
            foreach ($keys as $index => $key) {
                $column = $this->columns->get($index);

                if ($column->has('template')) {
                    $row[$key] = $this->templating->render(
                        $column->get('template'),
                        array(
                            'column' => $column,
                            'row'    => $row,
                        )
                    );
                }
            }

            $data['rows'][] = array(
                'id'   => $id,
                'cell' => array_intersect_key($row, array_flip($keys)),
            );
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
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
    public function setDataSource(DataSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }
}
