<?php

namespace App\Console\Commands;

use App\Http\Requests\UserCreateRequest;
use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class UserCreateCommand extends Command
{
    protected $signature = 'user:create
                            {name : The name of the user}
                            {email : The email of the user}
                            {password : The password for the user}';

    protected $description = 'Create a new user to system.';

    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $request = new UserCreateRequest();
        $request->replace([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
        ]);

        $validator = Validator::make(
            $request->all(),
            $request->rules(),
            $request->messages()
        );

        if ($validator->fails()) {
            $this->error('Validation errors:');

            foreach ($validator->errors()->all() as $error) {
                $this->error('- ' . $error);
            }

            return;
        }

        $this->userRepository->store($request->all());
    }
}
