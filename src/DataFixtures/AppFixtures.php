<?php

namespace App\DataFixtures;

use App\Entity\Sejour;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    const DEFAULT_USER = ['email' => 'user0@essai.com', 'password' =>  'sesameouvretoi'];

    /**
     * @var UserPasswordEncoderInterface
     */
    public $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $fake = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@essai.com');
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'sesameouvretoi'));
            if ($i % 5 == 0) {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }
            $manager->persist($user);
            for ($a=0; $a < random_int(4,10);$a++){
                $dateNow = new \DateTimeImmutable('now');
                $dateDeb = $dateNow->add(new \DateInterval('P' . $fake->numberBetween(5,90) . 'D'));

                $dateFin = $dateDeb->add(new \DateInterval('P' . $fake->numberBetween(3,30) . 'D'));


                $prix = $fake->numberBetween(200,4000);
                $somme_reglee = round($prix * random_int(0,1) / random_int(1,5),2);

                $article = (new Sejour())
                    ->setUser($user)
                    ->setDescription($fake->city)
                    ->setPrix($prix)
                    ->setSommeReglee($somme_reglee)
                    ->setDateDebut($dateDeb)
                    ->setDateFin($dateFin);
                $manager->persist($article);

                if ($somme_reglee > 0) {
                    $transaction = (new Transaction())
                        ->setUser($user)
                        ->setSejour($article)
                        ->setDateTransaction(new \DateTimeImmutable())
                        ->setMontant($somme_reglee)
                        ->setStatut(2);
                }
            }

        }

        $manager->flush();
    }
}
