<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


#[Signature('routes:check')]
#[Description('Check all routes')]
class CheckRoutes extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Route::getRoutes() as $route) {

            $methods = $route->methods();

            if (!in_array('GET', $methods)) {
                continue;
            }

            $uri = url($route->uri());

            try {

                $response = Http::get($uri);

                $this->info($uri.' => '.$response->status());

            } catch (\Throwable $e) {

                $this->error($uri.' => ERROR');
                $this->error($e->getMessage());
            }
        }
    }
}
