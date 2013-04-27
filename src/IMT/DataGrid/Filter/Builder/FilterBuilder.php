<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter\Builder;

use IMT\DataGrid\Filter\Group;
use IMT\DataGrid\Filter\Rule;

/**
 * This class represents the data grid filter builder
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class FilterBuilder implements FilterBuilderInterface
{
    /**
     * {@inheritDoc}
     */
    public function build(array $data)
    {
        $group = new Group(
            array_intersect_key($data, array_flip(array('groupOp')))
        );

        $groups = !array_key_exists('groups', $data)
            ? array()
            : $data['groups'];

        $rules = !array_key_exists('rules', $data)
            ? array()
            : $data['rules'];

        foreach ($groups as $data) {
            $group->addGroup($this->build($data));
        }

        foreach ($rules as $rule) {
            $group->addRule(new Rule($rule));
        }

        return $group;
    }
}
