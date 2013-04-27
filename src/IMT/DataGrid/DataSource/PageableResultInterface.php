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

/**
 * The interface for the pageable result
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface PageableResultInterface extends \IteratorAggregate
{
    /**
     * Gets the current page number
     *
     * @return integer
     */
    public function getCurrentPage();

    /**
     * Gets the total items count
     *
     * @return integer
     */
    public function getTotalItemsCount();

    /**
     * Gets the total pages count
     *
     * @return integer
     */
    public function getTotalPagesCount();
}
