<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PopulatePublishers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:publisher {number=20} {--api=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the publisher table with data from an API given. ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $args = $this->arguments();
        $opts = $this->options();

        

        return 0;
    }
}
