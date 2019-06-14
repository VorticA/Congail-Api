<?php
/**
 * A "router" class which extracts request information from the URL
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

    /**
     * Simply runs the router and gives the extracted info to the Controller Factory
     */
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