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

use IMT\DataGrid\Filter\Group;
use IMT\DataGrid\Filter\Rule;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class GroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Group
     */
    private $group;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->group = new Group(array('groupOp' => 'AND'));
    }

    /**
     * @covers IMT\DataGrid\Filter\Group::__construct
     */
    public function testConstructedWithoutRequiredOptionOp()
    {
        $this
            ->setExpectedException(
                'IMT\DataGrid\Exception\InvalidOptionsException'
            );

        new Group(array());
    }

    /**
     * @covers IMT\DataGrid\Filter\Group::__construct
     */
    public function testConstructedWithInvalidOptionOp()
    {
        $this
            ->setExpectedException(
                'IMT\DataGrid\Exception\InvalidOptionsException'
            );

        new Group(array('groupOp' => 'groupOp'));
    }

    /**
     * @covers IMT\DataGrid\Filter\Group::__construct
     * @covers IMT\DataGrid\Filter\Group::getGroups
     */
    public function testConstructedWithoutGroups()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->group->getGroups()
        );
        $this->assertCount(0, $this->group->getGroups());
    }

    /**
     * @covers IMT\DataGrid\Filter\Group::__construct
     * @covers IMT\DataGrid\Filter\Group::getRules
     */
    public function testConstructedWithoutRules()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->group->getRules()
        );
        $this->assertCount(0, $this->group->getRules());
    }

    /**
     * @covers IMT\DataGrid\Filter\Group::addGroup
     * @covers IMT\DataGrid\Filter\Group::getGroups
     */
    public function testGetFiltersWithOneFilter()
    {
        $returnStatement = $this->group->addGroup(clone $this->group);

        $this->assertSame($this->group, $returnStatement);
        $this->assertCount(1, $this->group->getGroups());
    }

    /**
     * @covers IMT\DataGrid\Filter\Group::getGroupOp
     */
    public function testGetGroupOp()
    {
        $this->assertEquals('AND', $this->group->getGroupOp());
    }

    /**
     * @covers IMT\DataGrid\Filter\Group::addRule
     * @covers IMT\DataGrid\Filter\Group::getRules
     */
    public function testGetRulesWithOneRule()
    {
        $returnStatement = $this->group->addRule(
            new Rule(
                array(
                    'field' => 'field',
                    'data'  => 'data',
                    'op'    => 'bn',
                )
            )
        );

        $this->assertSame($this->group, $returnStatement);
        $this->assertCount(1, $this->group->getRules());
    }
}
