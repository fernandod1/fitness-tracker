<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	    $user = User::where("email", "admin@admin.com")->first();
	    if(empty($user)){
	        User::create([
	            'name' => 'Admin',
	            'email' => 'admin@admin.com',
	            'password' => Hash::make('admin@admin.com')
	        ]);
	    }
    }
}
