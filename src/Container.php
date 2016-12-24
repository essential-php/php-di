<?php

namespace Essential\Di;

use Interop\Container\ContainerInterface;
use Essential\Di\Exception\ResolveFailedException;
use Essential\Di\Exception\NotFoundException;
use InvalidArgumentException;
use Error;

/**
 * Class Container
 *
 * @package Essential\Di
 * @author  Jamil Malek <jamil.malek@gmail.com>
 */
class Container implements ContainerInterface
{
    /**
     * Array of entries.
     *
     * @var array
     */
    private $entries = [];

    /**
     * Array of instances.
     *
     * @var array
     */
    private $instances = [];

    /**
     * Container constructor.
     *
     * @param array $entries Array of entries
     */
    public function __construct(array $entries = [])
    {
        foreach ($entries as $id => $class) {
            $instance = $this->resolve($class);
            $this->instances[$id] = $instance;
            $this->entries[$id] = $class;
        }
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        if (!is_string($id)) {
            throw new InvalidArgumentException(sprintf(
                'The id parameter must be of type string, %s given',
                is_object($id) ? get_class($id) : gettype($id)
            ));
        }

        if (false === $this->has($id)) {
            throw new NotFoundException($id);
        }

        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        try {
            return new $this->entries[$id];
        } catch (Error $e) {
            throw new ResolveFailedException($this->entries[$id]);
        }
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        return isset($this->entries[$id]);
    }

    /**
     * Add an entry to the container.
     *
     * @param  string $id    Identifier of the entry to add.
     * @param  string $class Class name of the entry to add.
     * @param  bool   $lazy  If true, instanciate when needed.
     * @return self
     * @throws ResolveFailedException Error while resolving the entry.
     */
    public function add($id, $class, $lazy = false) : self
    {
        if (false === $lazy) {
            $instance = $this->resolve($class);
            $this->instances[$id] = $instance;
        }

        $this->entries[$id] = $class;

        return $this;
    }

    /**
     * Remove an entry from the container by it's identifier.
     *
     * @param  string $id Identifier of the entry to remove.
     * @return self
     */
    public function remove($id) : self
    {
        unset($this->entries[$id]);
        unset($this->instances[$id]);

        return $this;
    }

    /**
     * Resolve entry name to instance.
     *
     * @param  string $class Class name of the entry to resolve.
     * @return mixed
     * @throws ResolveFailedException Error while resolving the entry.
     */
    private function resolve($class)
    {
        try {
            $instance = new $class();
        } catch (Error $e) {
            throw new ResolveFailedException($class);
        }

        return $instance;
    }
}
