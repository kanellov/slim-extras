<?php

/**
 * Knlv\Slim\Middleware\Callback
 *
 * @link https://github.com/kanellov/slim-extras
 * @copyright Copyright (c) 2015 Vassilis Kanellopoulos - contact@kanellov.com
 * @license https://raw.githubusercontent.com/kanellov/slim-extras/master/LICENSE
 */

namespace Knlv\Slim\Middleware;

use InvalidArgumentException;
use Slim\Middleware;

/**
 * Callback middleware.
 */
class Callback extends Middleware
{
    protected $callback;

    /**
     * Class constructor
     * @param callable $callback the autentication callback
     */
    public function __construct($callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException(sprintf(
                'Expected callable. %s given',
                (is_object($callback) ? get_class($callback) : gettype($callback))
            ));
        }

        $this->callback = $callback;
    }

    public function call()
    {
        call_user_func($this->callback, $this);
    }
}
