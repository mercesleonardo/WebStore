<?php

declare(strict_types = 1);

namespace Core\Pipeline;

use Closure;
use Core\Application;

class Pipeline
{
    protected mixed $passable;

    protected array $pipes = [];

    protected string $method = 'handle';

    public function __construct(
        protected Application $app
    ) {}

    public function send(mixed $passable): static
    {
        $this->passable = $passable;

        return $this;
    }

    public function through($pipes): static
    {
        $this->pipes = is_array($pipes) ? $pipes : func_get_args();

        return $this;
    }

    public function via(string $via): static
    {
        $this->method = $via;

        return $this;
    }

    public function then(Closure $destination)
    {
        $pipelines = array_reduce(
            array_reverse($this->pipes),
            $this->carry(),
            $this->prepareDestination($destination)
        );

        return $pipelines($this->passable);
    }

    private function carry(): Closure
    {
        return function ($carry, $pipe) {
            return function ($passable) use ($carry, $pipe) {
                $object = $this->app->build($pipe);

                return method_exists($object, $this->method)
                    ? $object->{$this->method}($passable, $carry)
                    : $object($passable, $carry);
            };
        };
    }

    private function prepareDestination(Closure $destination): Closure
    {
        return function ($passable) use ($destination) {
            return $destination($passable);
        };
    }
}
