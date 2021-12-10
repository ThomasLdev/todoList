<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
// these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    /**
     * @codeCoverageIgnore
     */
    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `User` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    /**
     * @codeCoverageIgnore
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
        // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($user);
            case self::EDIT:
                return $this->canEdit($user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @codeCoverageIgnore
     */
    private function canView(User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($user)) {
            return true;
        }

        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    private function canEdit(User $user): bool
    {
        // user has to be admin to edit or view users
        return (in_array('ROLE_ADMIN', $user->getRoles()));
    }
}