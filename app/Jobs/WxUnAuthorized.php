<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Star\Repositories\Eloquent\WxmpRepo;

class WxUnAuthorized extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * 根据微信授权动作，触发不同事件
     *
     * @return void
     */
    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        WxmpRepo::destroy($this->uid);
    }
}
