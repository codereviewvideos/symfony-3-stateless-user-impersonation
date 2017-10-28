<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Role\SwitchUserRole;

/**
 * @RouteResource("profile", pluralize=false)
 */
class ProfileController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Annotations\Get("/profile/{user}")
     * @ParamConverter("user", class="AppBundle:User")
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function getAction(
        AuthorizationCheckerInterface $authorizationChecker,
        TokenStorageInterface $tokenStorage,
        UserInterface $user
    )
    {
//        if ($authorizationChecker->isGranted('ROLE_PREVIOUS_ADMIN')) {
//            foreach ($tokenStorage->getToken()->getRoles() as $role) {
//                if ($role instanceof SwitchUserRole) {
//                    return $user;
//                }
//            }
//        }

        if ($user === $this->getUser()) {
            return $user;
        }

        return new JsonResponse(
            'Access denied',
            JsonResponse::HTTP_FORBIDDEN
        );
    }
}