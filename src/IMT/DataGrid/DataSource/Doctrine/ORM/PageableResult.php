<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\DataSource\Doctrine\ORM;

use Doctrine\ORM\Tools\Pagination\Paginator;

use IMT\DataGrid\DataSource\PageableResultInterface;

/**
 * This class represents the grid pageable result for Doctrine ORM
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class PageableResult implements PageableResultInterface
{
    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * The constructor method
     *
     * @param Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage()
    {
        $delta = $this->getTotalRowsCount()
            - $this->paginator->getQuery()->getFirstResult();

        return ($delta) < 1
            ? 1
            : ceil($delta / $this->paginator->getQuery()->getMaxResults());
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return $this->paginator->getIterator();
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalPagesCount()
    {
        return $this->getTotalRowsCount() < 1
            ? 1
            : ceil(
                $this->getTotalRowsCount()
                / $this->paginator->getQuery()->getMaxResults()
            );
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalRowsCount()
    {
        return $this->paginator->count();
    }
}
