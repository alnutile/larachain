<?php

namespace App\Console\Commands\Generators;

use Facades\App\Generators\ResponseType\GeneratorRepository;
use Illuminate\Console\Command;

class ResponseTypeGenerator extends Command
{
    public $signature = 'larachain:response_type:create';

    public $description = 'Generate the needed files for a new Response Type';

    public function handle(): int
    {
        $name = $this->ask('What is the name of this Response type, example WebFile');
        $description = $this->ask('A description to let the user know what it is for');
        $requires_settings = $this->anticipate('Will the user need to set some settings on this like, PromptToken or?', [
            true,
            false,
        ]);

        $results = sprintf("Does this look right, the name is %s, the description is %s and requires settings '%s'.",
        $name,
        $description,
        $requires_settings);

        if (! $this->confirm($results)) {
            $this->error('Ok try again');
            exit();
        }

        if (! $this->confirm('Lastly make sure your git status is clean so you can see what this command will output')) {
            $this->error('Ok come back in a moment after you git add .');
            exit();
        }

        $this->comment('Ok gonna go make the Generator one moment.');

        GeneratorRepository::setup($name, $description, $requires_settings)->run();

        $this->comment('All done, check your git status');

        return self::SUCCESS;
    }
}
