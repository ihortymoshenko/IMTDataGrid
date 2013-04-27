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

use IMT\DataGrid\Exception\InvalidOptionsException;

/**
 * This class represents the data grid filter rule
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Rule implements RuleInterface
{
    /**
     * An array of options
     *
     * @var array
     */
    protected $options = array();

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
    }

    /**
     * {@inheritDoc}
     */
    public function getData()
    {
        return $this->options['data'];
    }

    /**
     * {@inheritDoc}
     */
    public function getField()
    {
        return $this->options['field'];
    }

    /**
     * {@inheritDoc}
     */
    public function getOp()
    {
        return $this->options['op'];
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
                        'data' => array(
                            new Assert\NotBlank(),
                            new Assert\Type(
                                array(
                                    'type' => 'string',
                                )
                            ),
                        ),
                        'field' => array(
                            new Assert\NotBlank(),
                            new Assert\Type(
                                array(
                                    'type' => 'string',
                                )
                            ),
                        ),
                        'op'    => array(
                            new Assert\NotBlank(),
                            new Assert\Type(
                                array(
                                    'type' => 'string',
                                )
                            ),
                            new Assert\Choice(
                                array(
                                    'choices' => array(
                                        'bn',
                                        'bw',
                                        'cn',
                                        'en',
                                        'eq',
                                        'ew',
                                        'ge',
                                        'gt',
                                        'in',
                                        'le',
                                        'lt',
                                        'nc',
                                        'ne',
                                        'ni',
                                    )
                                )
                            ),
                        ),
                    ),
                )
            )
        );
    }
}
