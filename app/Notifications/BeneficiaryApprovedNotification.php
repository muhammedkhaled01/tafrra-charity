<?php

namespace App\Notifications;

use App\Broadcasting\WhatsAppChannel;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BeneficiaryApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Project $project)
    {
    }

    public function via(object $notifiable): array
    {
        // Route through our custom WhatsApp channel
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp(object $notifiable): string
    {
        return "مرحباً {$notifiable->name}، نود إبلاغكم بأنه تمت الموافقة على طلبكم في مبادرة '{$this->project->title}'.";
    }
}
