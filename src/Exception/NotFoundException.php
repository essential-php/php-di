<?php

namespace Essential\Di\Exception;

use Exception;
use Interop\Container\Exception\NotFoundException as NotFoundExceptionInterface;

/**
 * Class NotFoundException
 *
 * @package Essential\Di\Exception
 * @author  Jamil Malek <jamil.malek@gmail.com>
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface
{
    /**
     * NotFoundException constructor.
     *
     * @param string $id Identifier of the entry.
     */
    public function __construct(string $id)
    {
        $message = sprintf(
            '"%s" not found',
            $id
        );

        parent::__construct($message);
    }
}
