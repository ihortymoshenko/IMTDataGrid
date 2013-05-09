<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\Filter\Reflection\Doctrine\ORM;

use IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection;
use IMT\DataGrid\Filter\Filter;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class FilterReflectionTest extends AbstractTestCase
{
    /**
     * @var FilterReflection
     */
    private $filterReflection;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->filterReflection = new FilterReflection($this->queryBuilder);
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection::__construct
     */
    public function testConstructedWithDependencies()
    {
        $this->assertAttributeInstanceOf(
            'Doctrine\ORM\QueryBuilder',
            'queryBuilder',
            $this->filterReflection
        );
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection::reflect
     */
    public function testReflectWithNonExistingRuleReflection()
    {
        $filter = new Filter(array('groupOp' => 'AND'));
        $filter->addRule($this->getRuleMock('non-existing op'));

        $this->setExpectedException('IMT\DataGrid\Filter\Reflection\Exception\ReflectionNotFoundException');

        $this->filterReflection->reflect($filter);
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection::reflect
     */
    public function testReflectWithoutRules()
    {
        $filter = new Filter(array('groupOp' => 'AND'));

        $this->assertEquals(
            '',
            (string) $this->filterReflection->reflect($filter)
        );
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection::reflect
     */
    public function testReflectWithOneRule()
    {
        $filter = new Filter(array('groupOp' => 'AND'));
        $filter->addRule($this->getRuleMock());

        $this->assertEquals(
            'NOT(field LIKE ?1)',
            (string) $this->filterReflection->reflect($filter)
        );
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection::reflect
     */
    public function testReflectWithTwoRules()
    {
        $filter = new Filter(array('groupOp' => 'AND'));
        $filter
            ->addRule($this->getRuleMock())
            ->addRule($this->getRuleMock('bw'));

        $this->assertEquals(
            'NOT(field LIKE ?1) AND field LIKE ?2',
            (string) $this->filterReflection->reflect($filter)
        );
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection::reflect
     */
    public function testReflectWithTwoRulesAndOneNestedFilterWithoutRules()
    {
        $filter = new Filter(array('groupOp' => 'AND'));
        $filter
            ->addFilter(new Filter(array('groupOp' => 'AND')))
            ->addRule($this->getRuleMock())
            ->addRule($this->getRuleMock('bw'));

        $this->assertEquals(
            'NOT(field LIKE ?1) AND field LIKE ?2',
            (string) $this->filterReflection->reflect($filter)
        );
    }

    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\FilterReflection::reflect
     */
    public function testReflectWithTwoRulesAndOneNestedFilterWithTwoRules()
    {
        $filter = new Filter(array('groupOp' => 'AND'));
        $filter
            ->addRule($this->getRuleMock())
            ->addRule($this->getRuleMock('bw'));

        $nestedFilter = new Filter(array('groupOp' => 'AND'));
        $nestedFilter
            ->addRule($this->getRuleMock('cn'))
            ->addRule($this->getRuleMock('en'));

        $filter->addFilter($nestedFilter);

        $this->assertEquals(
            '(NOT(field LIKE ?1) AND field LIKE ?2) AND (field LIKE ?3 AND '
            . 'NOT(field LIKE ?4))',
            (string) $this->filterReflection->reflect($filter)
        );
    }
}
