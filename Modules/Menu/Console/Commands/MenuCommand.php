<?php

<<<<<<< HEAD
namespace Modules\Menu\Console\Commands;
=======
namespace Nasirkhan\ModuleManager\Modules\Menu\Console\Commands;
>>>>>>> c68af1d8ffb067e2aeebc0981e74d924bf367634

use Illuminate\Console\Command;

class MenuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MenuCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menu Command description';

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
