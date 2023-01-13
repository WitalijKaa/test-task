<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IsDbAlive extends Command
{
    protected $signature = 'mysql:is-alive';
    protected $description = 'Waits until DB will become alive on Docker start';

    const WAIT_SECS = 100;

    public function handle()
    {
        $cfg = config('database.connections.'.config('database.default'));
        $wait = 1;
        while($wait <= (static::WAIT_SECS / 2)) {

            echo 'Try DB connect ' . $cfg['host'] . ':' . $cfg['port'] . '/' . $cfg['database'] . PHP_EOL;

            try {
                DB::connection()->getPdo();
                echo 'Success!' . PHP_EOL;
                break;
            } catch (\Exception) {
                echo 'Error!' . PHP_EOL;
                sleep(2);
                $wait++;
            }
        }
        return 0;
    }
}
