<?php

namespace Essential\Di\Exception;

use Exception;
use Interop\Container\Exception\ContainerException as ContainerExceptionInterface;

/**
 * Class ResolveFailedException
 *
 * @package Essential\Di\Exception
 * @author  Jamil Malek <jamil.malek@gmail.com>
 */
class ResolveFailedException extends Exception implements ContainerExceptionInterface
{
    /**
     * ResolveFailedException constructor.
     *
     * @param string $class Class to resolve.
     */
    public function __construct(string $class)
    {
        $message = sprintf(
            'Failed to resolve "%s"',
            $class
        );

        parent::__construct($message);
    }
}
