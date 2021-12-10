<?php

namespace App\Security;

use App\Entity\Task;
use App\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['TASK_EDIT', 'TASK_DELETE', 'TASK_TOGGLE'])
            && $subject instanceof Task;
    }

    /**
     * @inheritDoc
     * @codeCoverageIgnore
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute == 'TASK_TOGGLE') {
            // user must be the author of the task or have admin role
            return $user === $subject->getUser() || in_array('ROLE_ADMIN', $user->getRoles());
        }

        if (in_array($attribute, ['TASK_EDIT', 'TASK_DELETE'])) {
            // user must be the author of the task, or have admin role in case of anonymous task
            return ($user === $subject->getUser()) || (in_array('ROLE_ADMIN', $user->getRoles()) && null === $subject->getUser());
        }

        return false;
    }
}