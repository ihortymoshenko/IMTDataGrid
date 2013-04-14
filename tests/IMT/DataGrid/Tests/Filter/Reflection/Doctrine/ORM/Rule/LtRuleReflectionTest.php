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

use IMT\DataGrid\Filter\Reflection\Doctrine\ORM\Rule\LtRuleReflection;
use IMT\DataGrid\Tests\Filter\Reflection\Doctrine\ORM\AbstractTestCase;

/**
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class LtRuleReflectionTest extends AbstractTestCase
{
    /**
     * @covers IMT\DataGrid\Filter\Reflection\Doctrine\ORM\Rule\LtRuleReflection::doReflect
     */
    public function testDoReflect()
    {
        $reflection = new LtRuleReflection($this->queryBuilder);

        $this->assertEquals(
            'field < ?1',
            (string) $reflection->doReflect($this->getRuleMock())
        );
    }
}
