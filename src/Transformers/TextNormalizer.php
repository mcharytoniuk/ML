<?php

namespace Rubix\ML\Transformers;

use Rubix\ML\DataType;

/**
 * Text Normalizer
 *
 * This transformer converts all text to lowercase and *optionally* removes
 * extra whitespace.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class TextNormalizer implements Transformer
{
    protected const SPACES_REGEX = '/\s+/';
    protected const SPACE = ' ';

    /**
     * Should we trim excess whitespace?
     *
     * @var bool
     */
    protected $trim;

    /**
     * @param bool $trim
     */
    public function __construct(bool $trim = false)
    {
        $this->trim = $trim;
    }

    /**
     * Return the data types that this transformer is compatible with.
     *
     * @return int[]
     */
    public function compatibility() : array
    {
        return DataType::ALL;
    }

    /**
     * Transform the dataset in place.
     *
     * @param array[] $samples
     */
    public function transform(array &$samples) : void
    {
        foreach ($samples as &$sample) {
            foreach ($sample as &$value) {
                if (is_string($value)) {
                    if ($this->trim) {
                        $value = preg_replace(self::SPACES_REGEX, self::SPACE, trim($value)) ?: '';
                    }

                    $value = strtolower($value);
                }
            }
        }
    }
}
