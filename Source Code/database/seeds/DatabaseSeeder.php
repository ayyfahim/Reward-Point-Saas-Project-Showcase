<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $language = 'en';
        $locale = 'en';

        $user = new \App\User;

        $user->role = 3;
        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('welcome123');
        $user->language = $language;
        $user->locale = $locale;
        $user->timezone = config('general.app_timezone');
        $user->app_name = config('app.name');
        $user->app_contact = config('general.mail_contact');
        $user->app_headline = config('general.app_headline');
        $user->app_mail_name_from =  config('general.mail_name_from');
        $user->app_mail_address_from =  config('general.mail_address_from');
        $user->app_color = '#304FFE';
        $user->app_host = str_replace(['http://', 'https://'], '', config('general.app_url'));
        $user->save();

        Eloquent::unguard();

        $this->call('IndustriesSeeder');
 
        if (config('app.demo')) {
          $this->call('DemoContentSeeder');
        }

        Eloquent::reguard();
    }
}
