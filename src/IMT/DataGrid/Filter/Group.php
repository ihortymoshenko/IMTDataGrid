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

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;

use Doctrine\Common\Collections\ArrayCollection;

use IMT\DataGrid\Exception\InvalidOptionsException;

/**
 * This class represents the data grid filter group
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Group implements GroupInterface
{
    /**
     * A collection of objects of type GroupInterface
     *
     * @var ArrayCollection
     */
    protected $groups;

    /**
     * An array of options
     *
     * @var array
     */
    protected $options = array();

    /**
     * A collection of objects of type RuleInterface
     *
     * @var ArrayCollection
     */
    protected $rules;

    /**
     * The constructor method
     *
     * @param  array                   $options An array of options
     * @throws InvalidOptionsException          If invalid options are passed
     */
    public function __construct(array $options)
    {
        $this->options = $options;

        $violations = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator()
            ->validate($this);

        if (count($violations) > 0) {
            throw new InvalidOptionsException($violations);
        }

        $this->groups = new ArrayCollection();
        $this->rules  = new ArrayCollection();
    }

    /**
     * {@inheritDoc}
     */
    public function addGroup(GroupInterface $group)
    {
        $this->groups->add($group);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addRule(RuleInterface $rule)
    {
        $this->rules->add($rule);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getGroupOp()
    {
        return $this->options['groupOp'];
    }

    /**
     * {@inheritDoc}
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritDoc}
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Loads the metadata for the validator
     *
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint(
            'options',
            new Assert\Collection(
                array(
                    'fields' => array(
                        'groupOp' => array(
                            new Assert\NotBlank(),
                            new Assert\Type(
                                array(
                                    'type' => 'string',
                                )
                            ),
                            new Assert\Choice(
                                array(
                                    'choices' => array(
                                        'AND',
                                        'OR',
                                    )
                                )
                            ),
                        )
                    ),
                )
            )
        );
    }
}
