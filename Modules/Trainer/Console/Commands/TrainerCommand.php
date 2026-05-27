<?php

namespace Modules\Trainer\Console\Commands;

use Illuminate\Console\Command;

class TrainerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TrainerCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trainer Command description';

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
