<?php
//tiny service sa container na naay bind. this stores bindings and reoloves dependencies via reflections.
declare(strict_types=1);

namespace Core\Container;

use Closure;
use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

final class Container
{
    private array $bindings = [];

    public function bind(string $abstract, string|object $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function get(string $id): object
    {
        $concrete = $this->bindings[$id] ?? $id;

        if (is_object($concrete) && ! $concrete instanceof Closure) {
            return $concrete;
        }

        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        return $this->build($concrete);
    }

    private function build(string $class): object
    {
        $reflection = new ReflectionClass($class);

        if (! $reflection->isInstantiable()) {
            throw new RuntimeException("Cannot instantiate {$class}");
        }

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return $reflection->newInstance();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if (! $type instanceof ReflectionNamedType || $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                    continue;
                }

                throw new RuntimeException("Cannot resolve parameter \${$parameter->getName()} for {$class}");
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
