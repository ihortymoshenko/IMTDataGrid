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

use IMT\DataGrid\Filter\Builder\FilterBuilder;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class FilterBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers IMT\DataGrid\Filter\Builder\FilterBuilder::build
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

        $filterBuilder = new FilterBuilder();

        /**
         * @var $group \IMT\DataGrid\Filter\GroupInterface
         */
        $group = $filterBuilder->build($data);

        $this->assertInstanceOf('IMT\DataGrid\Filter\GroupInterface', $group);
        $this->assertCount(1, $group->getGroups());
        $this->assertCount(0, $group->getGroups()->first()->getGroups());
        $this->assertCount(2, $group->getGroups()->first()->getRules());
        $this->assertCount(2, $group->getRules());
    }
}
