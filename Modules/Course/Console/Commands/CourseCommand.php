<?php

namespace Modules\Course\Console\Commands;

use Illuminate\Console\Command;

class CourseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CourseCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Course Command description';

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
