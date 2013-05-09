<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Manager\Exception;

/**
 * This class represents the exception that is thrown when the data grid builder
 * is not set
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
class DataGridBuilderNotSetException extends \RuntimeException
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct('The data grid builder is not set.');
    }
}
