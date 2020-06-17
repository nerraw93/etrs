<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AddStaffOnClients extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Save to `User` model first
        $staff = new User();
        $staff->email = 'perfect_staff@gmail.com';
        $staff->username = 'perfect.staff';
        $staff->password = bcrypt('secret');
        $staff->first_name = 'Perfect';
        $staff->last_name = 'Staff';
        $staff->role = User::ROLE_STAFF;
        $staff->save();

        // Save to `ClientStaff` model
        $clientStaff = new App\Models\ClientStaff();
        $clientStaff->client_id = User::where('email', 'perfect_client@gmail.com')->first()->id;
        $clientStaff->staff_id = $staff->id;
        $clientStaff->save();
    }
}
