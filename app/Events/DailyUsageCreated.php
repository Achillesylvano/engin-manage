<?php

namespace App\Events;

use App\Models\DailyUsage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DailyUsageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public DailyUsage $dailyUsage
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('daily-usages'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'daily.usage.created';
    }

    public function broadcastWith(): array
    {
        return [
            'daily_usage' => $this->dailyUsage->load('engin', 'operateur:id,name'),
        ];
    }
}
