<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::insert([

            //Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '1101',
                'address' => 'USA',
                'status' => 'active',
                'about' => 'I am the Admin',
                'website' => 'https://checkatreatment.com/',
                'fb_link' => 'https://www.facebook.com/',
                'tt_link' => 'https://www.tiktok.com/en/',
                'yt_link' => 'https://www.youtube.com/',
                'ig_link' => 'https://www.instagram.com/',

            ],

            //Vendor
            [
                'name' => 'Agent',
                'email' => 'agent@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'agent',
                'phone' => '1102',
                'address' => 'USA',
                'status' => 'active',
                'about' => 'I am the Agent',
                'website' => 'https://checkatreatment.com/',
                'fb_link' => 'https://www.facebook.com/',
                'tt_link' => 'https://www.tiktok.com/en/',
                'yt_link' => 'https://www.youtube.com/',
                'ig_link' => 'https://www.instagram.com/',
            ],

            //User
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '1103',
                'address' => 'UK',
                'status' => 'active',
                'about' => 'I am the User',
                'website' => 'https://checkatreatment.com/',
                'fb_link' => 'https://www.facebook.com/',
                'tt_link' => 'https://www.tiktok.com/en/',
                'yt_link' => 'https://www.youtube.com/',
                'ig_link' => 'https://www.instagram.com/',
            ]




        ]);
    }
}