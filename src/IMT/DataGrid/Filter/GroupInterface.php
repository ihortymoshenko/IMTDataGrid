<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Filter;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * The interface for the grid filter group
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
interface GroupInterface
{
    /**
     * Adds an instance of GroupInterface
     *
     * @param  GroupInterface $group
     * @return GroupInterface
     */
    public function addGroup(GroupInterface $group);

    /**
     * Adds an instance of RulInterface
     *
     * @param  RuleInterface  $rule
     * @return GroupInterface
     */
    public function addRule(RuleInterface $rule);

    /**
     * Gets the logical operator
     *
     * @return string
     */
    public function getGroupOp();

    /**
     * Gets a collection of objects of type GroupInterface
     *
     * @return ArrayCollection
     */
    public function getGroups();

    /**
     * Gets a collection of objects of type RuleInterface
     *
     * @return ArrayCollection
     */
    public function getRules();
}
