<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AppFixtures.
 */
class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // user
        $user = new User();
        $user->setPassword($this->encoder->encodePassword($user, 'admin'));
        $user->setEmail('admin@localhost.com');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setPassword($this->encoder->encodePassword($user, 'user'));
        $user->setEmail('user@localhost.com');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();

        //product
        for ($i = 0; $i < 20; ++$i) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setDescription(bin2hex(random_bytes(10)));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
