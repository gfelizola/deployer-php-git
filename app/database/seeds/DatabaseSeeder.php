<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call('UserTableSeeder');
	}

}


class UserTableSeeder extends Seeder {

    public function run()
    {
        User::create(array(
        	"username" => "gfelizola",
        	"nome"     => "Gustavo Felizola",
        	"avatar"   => "https://secure.gravatar.com/avatar/50fda58027e786277d6e06ce77aa5d86?d=https%3A%2F%2Fd3oaxc4q5k2d6q.cloudfront.net%2Fm%2F902c81e8bd81%2Fimg%2Fdefault_avatar%2F32%2Fuser_blue.png&s=32",
        ));
    }

}