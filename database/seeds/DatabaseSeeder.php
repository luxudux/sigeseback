<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $this->call(DelegationSeeder::class);
        $this->call(TypeSeeder::class);
        //$this->call(DelegationSeeder);
        $this->call(StateSeeder::class);
        $this->call(PreferenceSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(ConclutionSeeder::class);
        $this->call(TownSeeder::class);

        //DataFake
        // $this->call(OfficeSeeder::class);
        // $this->call(WorkerSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(ContactSeeder::class);
        // $this->call(CallSeeder::class);
        // $this->call(EventSeeder::class);
        // $this->call(DocumentSeeder::class);

        // $this->call(DocumentOfficeSeeder::class);
        // $this->call(DocumentStateSeeder::class);
        // $this->call(DocumentWorkerSeeder::class);
        // $this->call(OfficeUserSeeder::class);

        
    }
}
