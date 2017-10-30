<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @RouteResource("profile", pluralize=false)
 */
class ProfileController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Annotations\Get("/profile")
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function getAction(
        UserInterface $user
    )
    {
        if ($user === $this->getUser()) {
            return $user;
        }

        return new JsonResponse(
            'Access denied',
            JsonResponse::HTTP_FORBIDDEN
        );
    }
}