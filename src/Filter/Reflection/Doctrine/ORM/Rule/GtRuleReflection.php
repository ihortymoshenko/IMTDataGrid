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

use IMT\DataGrid\Filter\RuleInterface;

/**
 * This class reflects the `gt` comparison operator as `greater` on Doctrine ORM
 * Expr
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class GtRuleReflection extends AbstractRuleReflection
{
    /**
     * {@inheritDoc}
     */
    public function doReflect(RuleInterface $rule)
    {
        return $this->queryBuilder->expr()->gt(
            $rule->getField(),
            sprintf('?%d', $this->parameterKey)
        );
    }
}
