<?php

namespace Rubix\ML\Tests\Extractors;

use Rubix\ML\Extractors\CSV;
use Rubix\ML\Extractors\Extractor;
use PHPUnit\Framework\TestCase;
use IteratorAggregate;
use Traversable;

class CSVTest extends TestCase
{
    /**
     * @var \Rubix\ML\Extractors\CSV;
     */
    protected $extractor;

    public function setUp() : void
    {
        $this->extractor = new CSV('tests/test.csv', true, ',', '"');
    }

    public function test_build_extractor() : void
    {
        $this->assertInstanceOf(CSV::class, $this->extractor);
        $this->assertInstanceOf(Extractor::class, $this->extractor);
        $this->assertInstanceOf(IteratorAggregate::class, $this->extractor);
        $this->assertInstanceOf(Traversable::class, $this->extractor);
    }

    public function test_extract() : void
    {
        $expected = [
            ['attitude' => 'nice', 'texture' => 'furry', 'sociability' => 'friendly', 'rating' => '4', 'class' => 'not monster'],
            ['attitude' => 'mean', 'texture' => 'furry', 'sociability' => 'loner', 'rating' => '-1.5', 'class' => 'monster'],
            ['attitude' => 'nice', 'texture' => 'rough', 'sociability' => 'friendly', 'rating' => '2.6', 'class' => 'not monster'],
            ['attitude' => 'mean', 'texture' => 'rough', 'sociability' => 'friendly', 'rating' => '-1', 'class' => 'monster'],
            ['attitude' => 'nice', 'texture' => 'rough', 'sociability' => 'friendly', 'rating' => '2.9', 'class' => 'not monster'],
            ['attitude' => 'nice', 'texture' => 'furry', 'sociability' => 'loner', 'rating' => '-5', 'class' => 'not monster'],
        ];

        $records = iterator_to_array($this->extractor);

        $this->assertEquals($expected, $records);
    }
}
