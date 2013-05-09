<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Event;

use Symfony\Component\EventDispatcher\Event;

use IMT\DataGrid\HttpFoundation\RequestInterface;
use IMT\DataGrid\DataGridInterface;

/**
 * This class represents the data grid event that is thrown each time on binding
 * the given request
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class BindRequestEvent extends Event implements EventInterface
{
    /**
     * @var DataGridInterface
     */
    protected $dataGrid;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * The constructor method
     *
     * @param DataGridInterface $dataGrid
     * @param RequestInterface  $request
     */
    public function __construct(
        DataGridInterface $dataGrid,
        RequestInterface $request
    ) {
        $this->dataGrid = $dataGrid;
        $this->request  = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function getDataGrid()
    {
        return $this->dataGrid;
    }

    /**
     * Gets the request
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Sets the given request
     *
     * @param  RequestInterface $request
     * @return EventInterface
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }
}
