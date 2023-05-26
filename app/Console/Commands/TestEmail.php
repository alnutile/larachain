<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'totalrecalls:test_email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Yup!';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Mail::to(User::first())->send(
            new TestMail()
        );

        return 0;
    }
}
