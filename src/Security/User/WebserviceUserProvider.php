<?php

namespace App\Security\User;

use App\Security\User\WebserviceUser;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class WebserviceUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        //$client = new Client(['base_uri' => $uri]);
        //$user_response = $client->get('le_endpoint_api', ['auth' => [$username, <passord>]);
        // $user_response
        // make a call to your webservice here
        //$userData = ...
        // pretend it returns an array on success, false if there is no user

        /*  if ($userData) {
    $password = '...';

    // ...

    return new WebserviceUser($username, $password, $salt, $roles);
    }

    throw new UsernameNotFoundException(
    sprintf('Username "%s" does not exist.', $username)
    );*/
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Les instances de "%s" ne sont pas supportées.', get_class($user))
            );
        }

        return $user;
    }

    public function supportsClass($class): bool
    {
        return WebserviceUser::class === $class;
    }
}
