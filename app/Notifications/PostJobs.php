<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostJobs extends Notification
{
    use Queueable;
    public $request;
    /**
     * Create a new notification instance.
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        dd($this->request['job_type']);
        return [
            'mesasge' => $this->request->name . 'has posted new job !',
            'user_id' => $this->request->id,
            'job_id' => $this->request->job_id,
            'job_type' => $this->request->job_type,
        ];
    }
}
