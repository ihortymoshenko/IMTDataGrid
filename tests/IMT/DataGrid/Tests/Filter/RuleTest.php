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

use IMT\DataGrid\Filter\Rule;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class RuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Rule
     */
    private $rule;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->rule = new Rule(
            array(
                'data'  => 'data',
                'field' => 'field',
                'op'    => 'bn',
            )
        );
    }

    /**
     * @covers IMT\DataGrid\Filter\Rule::__construct
     */
    public function testConstructedWithoutRequiredOptionData()
    {
        $this->setExpectedException(
            'Symfony\Component\OptionsResolver\Exception\MissingOptionsException'
        );

        new Rule(array('field' => 'field', 'op' => 'bn'));
    }

    /**
     * @covers IMT\DataGrid\Filter\Rule::__construct
     */
    public function testConstructedWithoutRequiredOptionField()
    {
        $this->setExpectedException(
            'Symfony\Component\OptionsResolver\Exception\MissingOptionsException'
        );

        new Rule(array('data' => 'data', 'op' => 'bn'));
    }

    /**
     * @covers IMT\DataGrid\Filter\Rule::__construct
     */
    public function testConstructedWithoutRequiredOptionOp()
    {
        $this->setExpectedException(
            'Symfony\Component\OptionsResolver\Exception\MissingOptionsException'
        );

        new Rule(array('field' => 'field', 'data' => 'data'));
    }

    /**
     * @covers IMT\DataGrid\Filter\Rule::__construct
     */
    public function testConstructedWithInvalidOptionOp()
    {
        $this->setExpectedException(
            'Symfony\Component\OptionsResolver\Exception\InvalidOptionsException'
        );

        new Rule(array('field' => 'field', 'data' => 'data', 'op' => 'op'));
    }

    /**
     * @covers IMT\DataGrid\Filter\Rule::getData
     */
    public function testGetData()
    {
        $this->assertEquals('data', $this->rule->getData());
    }

    /**
     * @covers IMT\DataGrid\Filter\Rule::getField
     */
    public function testGetField()
    {
        $this->assertEquals('field', $this->rule->getField());
    }

    /**
     * @covers IMT\DataGrid\Filter\Rule::getOp
     */
    public function testGetOp()
    {
        $this->assertEquals('bn', $this->rule->getOp());
    }
}
