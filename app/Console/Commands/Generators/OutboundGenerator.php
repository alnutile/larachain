<?php

namespace App\Console\Commands\Generators;

use Facades\App\Generators\Outbound\GeneratorRepository;
use Illuminate\Console\Command;

class OutboundGenerator extends Command
{
    public $signature = 'larachain:outbound:create';

    public $description = 'Generate the needed files for a new Outbound';

    public function handle(): int
    {
        $name = $this->ask('What is the name of this Outbound type, example Api');
        $description = $this->ask('A description to let the user know what it is for');

        $results = sprintf("Does this look right, the name is %s, the description is %s and requires settings '%s'.",
        $name,
        $description,
        false);

        if (! $this->confirm($results)) {
            $this->error('Ok try again');
            exit();
        }

        if (! $this->confirm('Lastly make sure your git status is clean so you can see what this command will output')) {
            $this->error('Ok come back in a moment after you git add .');
            exit();
        }

        $this->comment('Ok gonna go make the Generator one moment.');

        GeneratorRepository::setup($name, $description, false)->run();

        $this->comment('All done, check your git status');

        return self::SUCCESS;
    }
}
