<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\DataSource;

use IMT\DataGrid\HttpFoundation\RequestInterface;

/**
 * The interface for the grid data source
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface DataSourceInterface
{
    /**
     * Binds the given request
     *
     * @param  RequestInterface    $request
     * @return DataSourceInterface
     */
    public function bindRequest(RequestInterface $request);

    /**
     * Gets the pageable result
     *
     * @param  boolean                 $distinctResults If set, distinct results
     *                                                  will be returned. By
     *                                                  default, true
     * @return PageableResultInterface
     */
    public function getPageableResult($distinctResults = true);
}
