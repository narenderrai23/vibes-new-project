<?php

namespace Modules\Auth\Console\Commands;

use Illuminate\Console\Command;

class AuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AuthCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auth Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
