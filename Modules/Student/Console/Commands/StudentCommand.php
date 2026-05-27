<?php

namespace Modules\Student\Console\Commands;

use Illuminate\Console\Command;

class StudentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:StudentCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Student Command description';

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
