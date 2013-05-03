<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\Filter;

use Doctrine\Common\Collections\ArrayCollection;

use IMT\DataGrid\Filter\Filter;
use IMT\DataGrid\Filter\Rule;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->filter = new Filter(array('groupOp' => 'AND'));
    }

    /**
     * @covers IMT\DataGrid\Filter\Filter::__construct
     */
    public function testConstructedWithoutRequiredOptions()
    {
        $this
            ->setExpectedException(
                'IMT\DataGrid\Exception\InvalidOptionsException'
            );

        new Filter(array());
    }

    /**
     * @covers IMT\DataGrid\Filter\Filter::__construct
     */
    public function testConstructedWithInvalidOptionOp()
    {
        $this
            ->setExpectedException(
                'IMT\DataGrid\Exception\InvalidOptionsException'
            );

        new Filter(array('groupOp' => 'groupOp'));
    }

    /**
     * @covers IMT\DataGrid\Filter\Filter::__construct
     * @covers IMT\DataGrid\Filter\Filter::getFilters
     */
    public function testConstructedWithoutFilters()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->filter->getFilters()
        );
        $this->assertCount(0, $this->filter->getFilters());
    }

    /**
     * @covers IMT\DataGrid\Filter\Filter::__construct
     * @covers IMT\DataGrid\Filter\Filter::getRules
     */
    public function testConstructedWithoutRules()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->filter->getRules()
        );
        $this->assertCount(0, $this->filter->getRules());
    }

    /**
     * @covers IMT\DataGrid\Filter\Filter::addFilter
     * @covers IMT\DataGrid\Filter\Filter::getFilters
     */
    public function testGetFiltersWithOneFilter()
    {
        $returnStatement = $this->filter->addFilter(clone $this->filter);

        $this->assertSame($this->filter, $returnStatement);
        $this->assertCount(1, $this->filter->getFilters());
    }

    /**
     * @covers IMT\DataGrid\Filter\Filter::getOperator
     */
    public function testGetOperator()
    {
        $this->assertEquals('AND', $this->filter->getOperator());
    }

    /**
     * @covers IMT\DataGrid\Filter\Filter::addRule
     * @covers IMT\DataGrid\Filter\Filter::getRules
     */
    public function testGetRulesWithOneRule()
    {
        $returnStatement = $this->filter->addRule(
            new Rule(
                array(
                    'field' => 'field',
                    'data'  => 'data',
                    'op'    => 'bn',
                )
            )
        );

        $this->assertSame($this->filter, $returnStatement);
        $this->assertCount(1, $this->filter->getRules());
    }
}
