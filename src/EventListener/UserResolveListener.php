<?php

namespace App\EventListener;

use App\Security\UserProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

final class UserResolveListener
{
    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * @param UserProviderInterface $userProvider
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserProvider $userProvider, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userProvider = $userProvider;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param UserResolveEvent $event
     */
    public function onUserResolve(UserResolveEvent $event): void
    {
        $user = $this->userProvider->loadUserByUsername($event->getUsername());

        if (null === $user) {
            return;
        }

        if (!$this->userPasswordEncoder->isPasswordValid($user, $event->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}
