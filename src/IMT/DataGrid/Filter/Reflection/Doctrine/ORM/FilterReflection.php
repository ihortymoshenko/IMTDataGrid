<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter\Reflection\Doctrine\ORM;

use Doctrine\ORM\Query\Expr\Base;
use Doctrine\ORM\QueryBuilder;

use IMT\DataGrid\Filter\Reflection\Exception\ReflectionNotFoundException;
use IMT\DataGrid\Filter\Reflection\ReflectionInterface;
use IMT\DataGrid\Filter\FilterInterface;

/**
 * This class represents the data grid filter reflection for Doctrine ORM
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class FilterReflection implements ReflectionInterface
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
     * @param  FilterInterface              $filter
     * @return Base
     * @throws ReflectionNotFoundException          If the data grid filter rule
     *                                              reflection class does not
     *                                              exist
     */
    public function reflect(FilterInterface $filter = null)
    {
        $exprParts = array();

        /**
         * @var $rule \IMT\DataGrid\Filter\RuleInterface
         */
        foreach ($filter->getRules() as $rule) {
            $ruleReflectionClass = sprintf(
                '%s\Rule\%sRuleReflection',
                __NAMESPACE__,
                ucfirst($rule->getOperator())
            );

            if (!class_exists($ruleReflectionClass)) {
                throw new ReflectionNotFoundException(
                    sprintf(
                        'The data grid filter rule reflection class named `%s` '
                        . 'does not exist.',
                        $ruleReflectionClass
                    )
                );
            }

            /**
             * @var $ruleReflection ReflectionInterface
             */
            $ruleReflection = new $ruleReflectionClass($this->queryBuilder);

            $exprParts[] = $ruleReflection->reflect($rule);
        }

        $exprOperation = mb_strtolower($filter->getOperator()) . 'X';
        $expr = call_user_func_array(
            array($this->queryBuilder->expr(), $exprOperation),
            $exprParts
        );

        $nestedExprParts = array();

        foreach ($filter->getFilters() as $nestedFilter) {
            $nestedExprParts[] = $this->reflect($nestedFilter);
        }

        if (count($nestedExprParts) == 0) {
            return $expr;
        }

        return call_user_func_array(
            array($this->queryBuilder->expr(), 'andX'),
            array_merge(array($expr), $nestedExprParts)
        );
    }
}
