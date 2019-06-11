<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/10/2019
 * Time: 2:53 PM
 */

namespace App;


class Router
{
    /**
     * @var ControllerFactory
     */
    private $factory;

    public function __construct(ControllerFactory $factory)
    {
        $this->factory = $factory;
    }

    public function Route()
    {
        $self = $_SERVER['PHP_SELF'];
        $request = $_SERVER['REQUEST_URI'];

        $exploded = explode("/", str_replace(str_replace('/index.php', "", $self)."/", "", $request));
        if (isset($exploded[0]) && isset($exploded[1]))
        {
            $data = ['handler' => $exploded[0], 'method' => $exploded[1]];
            $this->factory->RunController($data);
        }
        else throw new \Exception("Invalid command!");
    }
}