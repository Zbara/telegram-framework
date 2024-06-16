<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MessageSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $message;

    private int $is_send;
    private array $users;

    public function __construct(
        array $params
    )
    {
        $this->message = $params['message'];
        $this->is_send = $params['is_send'];
        $this->users = $params['users'];
    }

    public function handle(): void
    {

    }
}
