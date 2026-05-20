<?php

namespace Modules\Center\Console\Commands;

use Illuminate\Console\Command;

class CenterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CenterCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Center Command description';

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
