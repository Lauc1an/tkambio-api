<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class CreateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $users;
    private $filename;
    /**
     * Create a new job instance.
     *
     * @param  $users
     * @return void
     */
    public function __construct($users, $filename)
    {
        $this->users = $users;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Excel::store(new UsersExport($this->users), $this->filename);
    }
}
