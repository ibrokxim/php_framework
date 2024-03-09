<?php

namespace Ibrohim\Framework\Container;

use Ibrohim\Framework\Container\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{

    private array $services = [];
    public function add(string $id, string|object $concrete = null)
    {
        if (is_null($concrete)) {
            if (!class_exists($id)) {
                throw new ContainerException("Сервис с $id не найден");
            }
            $concrete = $id;
        }
        $this->services[$id] = $concrete;
    }

    public function get(string $id)
    {
        if (! $this->has($id)) {
            if (!class_exists($id)) {
                throw new ContainerException("Сервис $id не может быть resolved");
            }
            $this->add($id);
        }

        $instance = $this->resolve( $this->services[$id]);

        return $instance;
    }

    private function resolve($class)
    {
        $reflectionClass = new \ReflectionClass($class);

        $constructor = $reflectionClass->getConstructor();
        if (is_null($constructor)) {
            return $reflectionClass->newInstance();
        }

        $constructorParams = $constructor->getParameters();
        $classDependencies = $this->resolveCLassDependencies($constructorParams);

        $instance = $reflectionClass->newInstanceArgs($classDependencies);
        return $instance;
    }

    private function resolveClassDependencies(array $constructorParams): array
    {
        $classDependencies = [];

        /** @var \ReflectionParameter $constructorParams */
        foreach ($constructorParams as $constructorParam) {
            $serviceType = $constructorParam->getType();

            $service = $this->get($serviceType->getName());

            $classDependencies[] = $service;
            return $classDependencies;
        }
    }

    public function has(string $id): bool
    {
       return array_key_exists($id, $this->services);
    }


}