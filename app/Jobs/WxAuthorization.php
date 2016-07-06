<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Wxmp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Star\Repositories\Eloquent\WxmpRepo;
use Star\sms\proxy\BechSmsProxy;

class WxAuthorization extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * 根据微信授权动作，触发不同事件
     *
     * @return void
     */
    protected $wxmp;
    protected $data;
    public function __construct(Wxmp $wxmp, $data)
    {
        $this->wxmp = $wxmp;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->data) {
            case 'unauthorized':
                $this->wxmp->update(['authorized'=>false]);
                break;
            case 'authorized':
                $this->wxmp->update(['authorized'=>true]);
                break;
        }

        $sms = new BechSmsProxy($this->wxmp->users->first()->mobile, \Config::get("sms.Templates.$this->data"));
        $sms->fire();
    }
}
