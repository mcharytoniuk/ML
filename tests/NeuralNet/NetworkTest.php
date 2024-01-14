<?php

namespace Rubix\ML\Tests\NeuralNet;

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\NeuralNet\Network;
use Rubix\ML\NeuralNet\Layers\Dense;
use Rubix\ML\NeuralNet\Layers\Output;
use Rubix\ML\NeuralNet\Optimizers\Adam;
use Rubix\ML\NeuralNet\Layers\Activation;
use Rubix\ML\NeuralNet\Layers\Multiclass;
use Rubix\ML\NeuralNet\Layers\Placeholder1D;
use Rubix\ML\NeuralNet\ActivationFunctions\ReLU;
use Rubix\ML\NeuralNet\CostFunctions\CrossEntropy;
use PHPUnit\Framework\TestCase;

/**
 * @group NeuralNet
 * @covers \Rubix\ML\NeuralNet\Network
 */
class NetworkTest extends TestCase
{
    /**
     * @var Labeled
     */
    protected $dataset;

    /**
     * @var Network
     */
    protected $network;

    /**
     * @var \Rubix\ML\NeuralNet\Layers\Input
     */
    protected $input;

    /**
     * @var \Rubix\ML\NeuralNet\Layers\Hidden[]
     */
    protected $hidden;

    /**
     * @var Output
     */
    protected $output;

    /**
     * @before
     */
    protected function setUp() : void
    {
        $this->dataset = Labeled::quick([
            [1.0, 2.5],
            [0.1, 0.0],
            [0.002, -6.0],
        ], ['yes', 'no', 'maybe']);

        $this->input = new Placeholder1D(2);

        $this->hidden = [
            new Dense(10),
            new Activation(new ReLU()),
            new Dense(5),
            new Activation(new ReLU()),
            new Dense(3),
        ];

        $this->output = new Multiclass(['yes', 'no', 'maybe'], new CrossEntropy());

        $this->network = new Network($this->input, $this->hidden, $this->output, new Adam(0.001));
    }

    /**
     * @test
     */
    public function build() : void
    {
        $this->assertInstanceOf(Network::class, $this->network);
        $this->assertInstanceOf(Network::class, $this->network);
    }

    /**
     * @test
     */
    public function layers() : void
    {
        $this->assertCount(7, $this->network->layers());
    }

    /**
     * @test
     */
    public function input() : void
    {
        $this->assertInstanceOf(Placeholder1D::class, $this->network->input());
    }

    /**
     * @test
     */
    public function hidden() : void
    {
        $this->assertCount(5, $this->network->hidden());
    }

    /**
     * @test
     */
    public function output() : void
    {
        $this->assertInstanceOf(Output::class, $this->network->output());
    }

    /**
     * @test
     */
    public function numParams() : void
    {
        $this->network->initialize();

        $this->assertEquals(103, $this->network->numParams());
    }

    /**
     * @test
     */
    public function roundtrip() : void
    {
        $this->network->initialize();

        $loss = $this->network->roundtrip($this->dataset);

        $this->assertIsFloat($loss);
    }
}
