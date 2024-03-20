<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StockTransfer;
use Carbon\Carbon;

class DeleteOldStockTransfers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old-stock-transfers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old stock transfers';

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
        $oneMonthAgo = Carbon::now()->subMonth();
        StockTransfer::where('updated_at', '<', $oneMonthAgo)->delete();

        $this->info('Old stock transfers deleted successfully.');
    }
}
