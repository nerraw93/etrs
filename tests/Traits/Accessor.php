<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use DB;

/**
 * Trait for user accesor, to logged in as user, as admin etc...
 *
 * @author goper
 */
trait Accessor {

    /**
     * Login user
     *
     * @author goper
     * @param  string $email
     * @return void
     */
    public function loggedUser($email)
    {
        if ($email == 'random') {
            $randomUser = User::orderByRaw('RAND()')->client()->first();
            $email = $randomUser->email;
        }
        $this->user = User::where('email', $email)->first();
    }

    /**
     * Login client user
     *
     * @author goper
     * @return void
     */
    public function loggedUserClient($email = '')
    {
        if ($email != '') {
            $user = User::where('email', $email)->first();
        } else {
            $user = User::orderByRaw('RAND()')->client()->first();
        }

        $this->loggedUser($user->email);
    }

    /**
     * Login user admin
     */
    public function loggedUserAsAdmin()
    {
        $user = User::orderByRaw('RAND()')->admin()->first();
        $this->loggedUser($user->email);
    }

    /**
     * Login user processor
     */
    public function loggedUserAsProcessor()
    {
        $user = User::where('role', User::ROLE_PROCESSOR)->orderByRaw('RAND()')->first();
        $this->loggedUser($user->email);
    }

    /**
     * Login user processor
     */
    public function loggedUserAsStaff($email)
    {
        if ($email != '') {
            $user = User::where('email', $email)->first();
        } else {
            $user = User::orderByRaw('RAND()')->staff()->first();
        }

        $this->loggedUser($user->email);
    }

    /**
     * Logged user as admin
     *
     * @author goper
     * @return void
     */
    public function asAdmin()
    {
        $this->loggedUserAsAdmin();
        Passport::actingAs($this->user);
    }

    /**
     * Logged user as client
     * @return void
     */
    public function asClient($email = '')
    {
        $this->loggedUserClient($email);
        Passport::actingAs($this->user);
    }

    /**
     * Logged user as staff
     * @return void
     */
    public function asStaff($email = '')
    {
        $this->loggedUserAsStaff($email);
        Passport::actingAs($this->user);
    }

    /**
     * Logged user as `processor`
     * @return void
     */
    public function asProcessor($email = '')
    {
        $this->loggedUserAsProcessor($email);
        Passport::actingAs($this->user);
    }

    /**
     * Logged user as staff `perfect`
     *
     * @return void
     */
    public function loggedPerfectStaff()
    {
        $this->asStaff('perfect_staff@gmail.com');
    }
}
