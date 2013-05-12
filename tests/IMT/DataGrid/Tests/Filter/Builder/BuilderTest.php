<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Tests\Filter\Builder;

use IMT\DataGrid\Filter\Builder\Builder;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class FilterBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->builder = new Builder();
    }

    /**
     * @covers IMT\DataGrid\Filter\Builder\Builder::build
     */
    public function testBuild()
    {
        $data = array(
            'groupOp' => 'AND',
            'rules'   => array(
                array(
                    'field' => 'field',
                    'data'  => 'data',
                    'op'    => 'bn',
                ),
                array(
                    'field' => 'field',
                    'data'  => 'data',
                    'op'    => 'bw',
                ),
            ),
        );
        $data['groups'][] = $data;

        /**
         * @var $filter \IMT\DataGrid\Filter\FilterInterface
         */
        $filter = $this->builder->build($data);

        $this->assertInstanceOf('IMT\DataGrid\Filter\FilterInterface', $filter);
        $this->assertCount(2, $filter->getRules());

        $nestedFilters = $filter->getFilters();

        $this->assertCount(1, $nestedFilters);
        $this->assertCount(0, $nestedFilters[0]->getFilters());
        $this->assertCount(2, $nestedFilters[0]->getRules());
    }
}
