<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\en_US\Person($faker));
        $faker->addProvider(new Faker\Provider\Internet($faker));
        $faker->addProvider(new Faker\Provider\File($faker));
        $faker->addProvider(new Faker\Provider\Uuid($faker));

        $need = 1000000;
        $count = 0;

        while($count < $need)
        {
            $count_files = rand(1, 5);
            $uuid = $faker->uuid;

            for ($k=0; $k < $count_files; $k++)
            {
                \App\MediaStorage\Files::create([
                    'email' => $faker->freeEmail,
                    'user' => $uuid,
                    'file' => md5(time().rand(100,1000000)),
                    'ext' => 'jpg',
                    'description' => 'test description of file',
                ]);

                $count++;

                if($count > 0 && $count % 10000 == 0)
                {
                    echo 'sleep after '.$count."\n";
                    usleep(100000);
                    echo 'run...'."\n";
                }
            }
        }

    }
}


