<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 10/16/15
 * Time: 4:49 AM
 */

namespace AppBundle\Handler;


use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    protected $container;

    public function __construct(HttpUtils $httpUtils, \Symfony\Component\DependencyInjection\ContainerInterface $cont, array $options)
    {
        parent::__construct($httpUtils, $options);
        $this->container=$cont;
    }
}