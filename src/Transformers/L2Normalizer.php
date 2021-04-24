<?php

namespace Rubix\ML\Transformers;

use Rubix\ML\DataType;

/**
 * L2 Normalizer
 *
 * Transform each sample vector in the sample matrix such that each feature is divided by
 * the L2 norm (or *magnitude*) of that vector. The resulting sample will have continuous
 * features between 0 and 1.
 *
 * @category    Machine Learning
 * @package     Rubix/ML
 * @author      Andrew DalPino
 */
class L2Normalizer extends LambdaFunction
{
    public function __construct()
    {
        parent::__construct([$this, 'normalize']);
    }

    /**
     * Return the data types that this transformer is compatible with.
     *
     * @internal
     *
     * @return list<\Rubix\ML\DataType>
     */
    public function compatibility() : array
    {
        return [
            DataType::continuous(),
        ];
    }

    /**
     * Normalize a sample by its L2 norm.
     *
     * @param list<int|float> $sample
     */
    protected function normalize(array &$sample) : void
    {
        $norm = 0.0;

        foreach ($sample as $value) {
            $norm += $value ** 2;
        }

        if ($norm === 0.0) {
            return;
        }

        $norm = sqrt($norm);

        foreach ($sample as &$value) {
            $value /= $norm;
        }
    }

    /**
     * Return the string representation of the object.
     *
     * @return string
     */
    public function __toString() : string
    {
        return 'L2 Normalizer';
    }
}
