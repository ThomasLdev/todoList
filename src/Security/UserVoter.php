<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends \Symfony\Component\Security\Core\Authorization\Voter\Voter
{

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, ['USER_EDIT', 'USER_DELETE'])
            && $subject instanceof \App\Entity\User;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ROLE_ADMIN can do anything on users!
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        // ROLE_USER can edit or delete only one's own user account
        if (in_array($attribute, ['USER_EDIT', 'USER_DELETE'])) {
            return $user === $subject;
        }

        return false;
    }
}