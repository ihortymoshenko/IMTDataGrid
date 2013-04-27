<?php

/*
 * This file is part of the IMTDataGrid package.
 *
 * (c) Igor M. Timoshenko <igor.timoshenko@i.ua>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IMT\DataGrid\Column;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;

use IMT\DataGrid\Exception\InvalidOptionsException;

/**
 * This class represents the grid column
 *
 * @author Igor Timoshenko <igor.timoshenko@i.ua>
 */
class Column implements ColumnInterface
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
    public function get($option)
    {
        return $this->options[$option];
    }

    /**
     * {@inheritDoc}
     */
    public function has($option)
    {
        return array_key_exists($option, $this->options);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->options;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint(
            'options',
            new Assert\Collection(
                array(
                    'fields' => array(
                        'index' => array(
                            new Assert\NotBlank(),
                            new Assert\Type(
                                array(
                                    'type' => 'string',
                                )
                            )
                        ),
                        'name'  => array(
                            new Assert\NotBlank(),
                            new Assert\Type(
                                array(
                                    'type' => 'string',
                                )
                            )
                        ),
                    ),
                    'allowExtraFields' => true,
                )
            )
        );
    }
}
