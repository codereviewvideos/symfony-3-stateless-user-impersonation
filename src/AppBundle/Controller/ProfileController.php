<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @RouteResource("profile", pluralize=false)
 */
class ProfileController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Annotations\Get("/profile")
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function getAction()
    {
        if (null === $this->getUser()) {
            return new JsonResponse(
                'Access denied',
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        return $this->getUser();
    }
}