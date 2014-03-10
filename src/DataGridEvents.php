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

/**
 * This class serves to define and document events
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
final class DataGridEvents
{
    /**
     * The data_grid.pre_bind_request event is thrown each time before binding
     * the given request
     *
     * The event listener receives an instance of
     * IMT\DataGrid\Event\EventInterface
     *
     * @var string
     */
    const PRE_BIND_REQUEST  = 'data_grid.pre_bind_request';

    /**
     * The data_grid.post_bind_request event is thrown each time after binding
     * the given request
     *
     * The event listener receives an instance of
     * IMT\DataGrid\Event\EventInterface
     *
     * @var string
     */
    const POST_BIND_REQUEST = 'data_grid.post_bind_request';
}
