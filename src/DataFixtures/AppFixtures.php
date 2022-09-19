<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadNews($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$username, $password, $email, $roles]) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // [$username, $password, $email, $roles];
            ['admin', 'admin', 'admin@admin.com', ['ROLE_ADMIN']],
            ['user', 'user', 'user@user.com', ['ROLE_USER']],
        ];
    }

    private function loadNews(ObjectManager $manager): void
    {
        //
        ////        for ($i=0; $i<=1; $i++) {
        //            $news = new News();
        //            $news->setTitle('Title-' . rand(1,1000) );
        //            $news->setDelete(1);
        //            $news->setDescription('Description-' . rand(1,1000) );
        //            $news->getImage('https://s.yimg.com/os/');
        //
        //
        ////
        ////             $news->setUpdateAt( new \DateTime('now + '. 1 .'seconds') );
        ////
        ////             $news->setCreateAt( new \DateTime('now + '. 1 .'seconds') );
        //            $manager->persist($news);
        //
        //            $manager->flush();
        //        }
    }
}
