<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\Filter\Reflection\Doctrine\ORM\Rule;

use Doctrine\ORM\QueryBuilder;

use IMT\DataGrid\Filter\Reflection\Doctrine\ORM\Rule\AbstractRuleReflection;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class AbstractRuleReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractRuleReflection
     */
    private $abstractRuleReflection;

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

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

        $this->queryBuilder = new QueryBuilder($entityManager);

        $this->abstractRuleReflection = $this
            ->getMockForAbstractClass(
                'IMT\DataGrid\Filter\Reflection\Doctrine\ORM\Rule\AbstractRuleReflection',
                array($this->queryBuilder)
            );
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\Rule\AbstractRuleReflection::__construct
     */
    public function testConstructedWithDependencies()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\ORM\QueryBuilder',
            'queryBuilder',
            $this->abstractRuleReflection
        );
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\Rule\AbstractRuleReflection::setParameterValue
     */
    public function testSetParameterValue()
    {
        $this->abstractRuleReflection->setParameterValue('data');

        $this->assertEquals(
            'data',
            $this->queryBuilder->getParameter(1)->getValue()
        );
    }
}
