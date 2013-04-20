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

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

use IMT\DataGrid\DataSource\DataSourceInterface;
use IMT\DataGrid\Filter\Builder\FilterBuilder;
use IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection;
use IMT\DataGrid\HttpFoundation\RequestInterface;

/**
 * This class represents the grid data source for Doctrine ORM
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class DataSource implements DataSourceInterface
{
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * The constructor method
     *
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function bindRequest(RequestInterface $request)
    {
        if ($request->isSearch() && $request->getFilters()) {
            $this
                ->queryBuilder
                ->where(
                    $this->getFilterReflection()->reflect(
                        $this->getFilterBuilder()->build(
                            $request->getFilters()
                        )
                    )
                );
        }

        if ($request->getSort() && $request->getOrder()) {
            $this
                ->queryBuilder
                ->orderBy($request->getSort(), $request->getOrder());
        }

        $this
            ->queryBuilder
            ->setFirstResult(
                abs($request->getPage() - 1) * $request->getLimit()
            )
            ->setMaxResults($request->getLimit());
    }

    /**
     * {@inheritDoc}
     */
    public function getPageableResult($distinctResults = true)
    {
        return new PageableResult(
            new Paginator($this->queryBuilder, $distinctResults)
        );
    }

    /**
     * @return FilterBuilder
     */
    protected function getFilterBuilder()
    {
        return new FilterBuilder();
    }

    /**
     * @return FilterReflection
     */
    protected function getFilterReflection()
    {
        return new FilterReflection($this->queryBuilder);
    }
}
