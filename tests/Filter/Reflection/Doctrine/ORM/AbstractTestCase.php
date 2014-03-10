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

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var Expr
     */
    private $expressionBuilder;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager
            ->expects($this->any())
            ->method('getExpressionBuilder')
            ->will($this->returnCallback(array($this, 'getExpressionBuilder')));

        $this->queryBuilder = new QueryBuilder($entityManager);
    }

    /**
     * @see Doctrine\ORM\Query\EntityManager::getExpressionBuilder()
     */
    public function getExpressionBuilder()
    {
        if ($this->expressionBuilder === null) {
            $this->expressionBuilder = new Expr();
        }

        return $this->expressionBuilder;
    }

    /**
     * @param  string                             $op
     * @return \IMT\DataGrid\Filter\RuleInterface
     */
    protected function getRuleMock($op = 'bn')
    {
        $rule = $this->getMock('IMT\DataGrid\Filter\RuleInterface');
        $rule
            ->expects($this->any())
            ->method('getData')
            ->will($this->returnValue('data'));
        $rule
            ->expects($this->any())
            ->method('getField')
            ->will($this->returnValue('field'));
        $rule
            ->expects($this->any())
            ->method('getOperator')
            ->will($this->returnValue($op));

        return $rule;

    }
}
