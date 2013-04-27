<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter\Reflection\Doctrine\ORM\Rule;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

use IMT\DataGrid\Filter\Reflection\ReflectionInterface;
use IMT\DataGrid\Filter\RuleInterface;

/**
 * The base class for the data grid filter rule reflection for Doctrine ORM
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
abstract class AbstractRuleReflection implements ReflectionInterface
{
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * The parameter key
     *
     * @var integer
     */
    protected $parameterKey;

    /**
     * Reflects the given data grid filter rule
     *
     * @param  RuleInterface $rule
     * @return Expr
     */
    abstract public function doReflect(RuleInterface $rule);

    /**
     * The constructor method
     *
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;

        $this->calculateParameterKey();
    }

    /**
     * {@inheritDoc}
     * @param  RuleInterface $rule
     * @return Expr
     */
    public function reflect(RuleInterface $rule = null)
    {
        $this->setParameterValue($rule->getData());

        return $this->doReflect($rule);
    }

    /**
     * Sets the parameter value
     *
     * @param mixed $value The parameter value
     */
    public function setParameterValue($value)
    {
        $this->queryBuilder->setParameter($this->parameterKey, $value);
    }

    /**
     * Calculates the parameter key
     */
    private function calculateParameterKey()
    {
        $this->parameterKey = count($this->queryBuilder->getParameters()) + 1;
    }
}
