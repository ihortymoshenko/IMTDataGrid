<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Exception;

/**
 * This class represents the exception that is thrown when the grid data source
 * is not set
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
class DataSourceNotSetException extends \RuntimeException
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct('The grid data source is not set.');
    }
}
