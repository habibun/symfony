<?php

namespace App\Security;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ProductVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on Product objects inside this voter
        if (!$subject instanceof Product) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

//        if (!$this->security->isGranted('ROLE_SUPER_ADMINE')) {
//            return false;
//        }

        // you know $subject is a Product object, thanks to supports
        /** @var Product $product */
        $product = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($product, $user);
            case self::EDIT:
                return $this->canEdit($product, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Product $product, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($product, $user)) {
            return true;
        }

        // the Product object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return !$product->isPrivate();
    }

    private function canEdit(Product $product, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $product->getOwner();
    }
}
