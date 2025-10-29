<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class UserCreateCommand extends Command
{
    protected $signature = 'user:create
        {name : Nome do usuário}
        {email : E-mail do usuário}
        {password : Senha do usuário}';

    protected $description = 'Command to create a new user';

    public function __construct(readonly private CreatesNewUsers $newUser)
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $data = [
                'name' => $this->argument('name'),
                'email' => $this->argument('email'),
                'password' => $this->argument('password')
            ];

            $this->newUser->create($data);

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('Error to create user: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
