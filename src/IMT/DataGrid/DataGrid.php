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

use Symfony\Component\Templating\EngineInterface;

use Doctrine\Common\Collections\ArrayCollection;

use IMT\DataGrid\Column\ColumnInterface;
use IMT\DataGrid\DataSource\DataSourceInterface;
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
     * @var ArrayCollection
     */
    protected $columns;

    /**
     * @var DataSourceInterface
     */
    protected $dataSource;

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
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;

        $this->columns = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function addColumn(ColumnInterface $column)
    {
        $this->columns->set($column->get('index'), $column);

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

        $this->dataSource->bindRequest($request);

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

        foreach ($pageableResult as $id => $row) {
            if ($this->columns->containsKey($id)) {
                /**
                 * @var $column ColumnInterface
                 */
                $column = $this->columns->get($id);

                if ($column->has('template')) {
                    $row = $this->templating->render(
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
                'cell' => $row,
            );
        }

        return $data;
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
