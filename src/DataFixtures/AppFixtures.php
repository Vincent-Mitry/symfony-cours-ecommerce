<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{

    protected $slugger;
    protected $encoder;

    public function __construct(SluggerInterface $slugger, UserPasswordEncoderInterface $encoder)
    {
        $this->slugger = $slugger;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        $admin = new User;

        $hash = $this->encoder->encodePassword($admin, "password");

        $admin->setEmail("admin@gmail.com")
            ->setPassword($hash)
            ->setFullName("Admin")
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $users = [];

        $products = [];
        
        for ($u = 1; $u < 6; $u++) {
            $user = new User;

            $hash = $this->encoder->encodePassword($user, "password");

            $user->setEmail("user$u@gmail.com")
                ->setFullName($faker->name())
                ->setPassword($hash);

            $users[] = $user;

            $manager->persist($user);
        }

        for($c = 0; $c < 3; $c++) {
            $category = new Category;
            $category->setName($faker->word())
                    ->setSlug(strtolower($this->slugger->slug($category->getName())));

            $manager->persist($category);

            for ($p = 0; $p < mt_rand(15, 20); $p++) {
                $product = new Product;
                $product->setName($faker->productName())
                        ->setPrice($faker->price(4000,20000))
                        ->setSlug(strtolower($this->slugger->slug($product->getName())))
                        ->setCategory($category)
                        ->setShortDescription($faker->paragraph())
                        ->setMainPicture($faker->imageUrl(400, 400, true));
                
                $products[] = $product;
                
                $manager->persist($product);
            }
        }

        for($p = 0; $p < mt_rand(20, 40); $p++)
        {
            $purchase = new Purchase;

            $purchase->setFullName($faker->name)
                    ->setAddress($faker->streetAddress())
                    ->setPostalCode($faker->postcode())
                    ->setCity($faker->city())
                    ->setUser($faker->randomElement($users))
                    ->setTotal(mt_rand(2000, 30000))
                    ->setPurchasedAt($faker->dateTimeBetween('- 6 months'));

            $selectedProducts = $faker->randomElements($products, mt_rand(3,5));

            foreach($selectedProducts as $product)
            {
                $purchase->addProduct($product);
            }
                    
                
            if($faker->boolean(90)) {
                $purchase->setStatus(Purchase::STATUS_PAID);
            }

            $manager->persist($purchase);
        }

        $manager->flush();
    }
}
