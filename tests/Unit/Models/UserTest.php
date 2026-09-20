<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Repositories\UserRepository;
use Tests\TestCase;

class UserTest extends TestCase
{
    
    public function test_set_name_lowercase()
    {
        $user             = new User();
        $user->first_name = 'JESUS ANTONIO';
        
        $this->assertEquals('jesus antonio', $user->first_name);
    }
    
    public function test_set_lastname_lowercase()
    {
        $user            = new User();
        $user->last_name = 'REYES OSORIO';
        
        $this->assertEquals('reyes osorio', $user->last_name);
    }
    
    public function testGetUser()
    {
        $users = UserRepository::getUser(['id' => 100])->first();
    
        $this->assertInstanceOf(User::class, $users);
        
    }
}
