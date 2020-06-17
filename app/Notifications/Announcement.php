<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Broadcasting\PrivateChannel;
use App\Helpers\Factory\AnnouncementFactory;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\CustomDbChannel;
use Illuminate\Queue\SerializesModels;

class Announcement extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue, Dispatchable;

    protected $announcement;

    protected $userId;

    private $batch;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userId, $announcement, $batch)
    {
        $this->announcement = $announcement;
        $this->userId = $userId;
        $this->batch = $batch;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['broadcast', 'database'];
        return [CustomDbChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'topic' => $this->announcement['topic'],
            'content' => $this->announcement['content'],
            'start_date' => $this->announcement['start_date'],
            'end_date' => $this->announcement['end_date'],
            'batch_id' => $this->batch,
            'user_id' => $this->userId,
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'topic' => $this->announcement['topic'],
            'content' => $this->announcement['content'],
            'start_date' => $this->announcement['start_date'],
            'end_date' => $this->announcement['end_date'],
            'batch_id' => $this->batch,
            'user_id' => $this->userId,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("announcement.{$this->userId}");
    }
}
