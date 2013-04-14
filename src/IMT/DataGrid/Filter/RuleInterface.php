<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter;

/**
 * The interface for the grid filter rule
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 * @codeCoverageIgnore
 */
interface RuleInterface
{
    /**
     * Gets the data
     *
     * @return string
     */
    public function getData();

    /**
     * Gets the field name
     *
     * @return string
     */
    public function getField();

    /**
     * Gets the comparison operator
     *
     * @return string
     */
    public function getOp();
}
