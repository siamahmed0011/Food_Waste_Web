<?php

namespace App\Notifications;

use App\Models\FoodPost;
use App\Models\Ngo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $ngo;
    public $food;

    public function __construct(Ngo $ngo, FoodPost $food)
    {
        $this->ngo  = $ngo;
        $this->food = $food;
    }

    public function via($notifiable)
    {
        // Email + database (dashboard)
        return ['mail', 'database'];
    }

    // Email message
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your food donation was accepted')
            ->greeting('Hi ' . $notifiable->name . ' 👋')
            ->line('Good news! The organization "' . $this->ngo->name . '" has accepted your donation.')
            ->line('Food: ' . $this->food->title . ' (' . $this->food->quantity . ' ' . $this->food->unit . ')')
            ->line('Pickup address: ' . $this->food->pickup_address)
            ->line('They will arrange pickup within your specified time window.')
            ->line('Thank you for helping reduce food waste 💚');
    }

    // Database data (dashboard notifications)
    public function toDatabase($notifiable)
    {
        return [
            'ngo_name'   => $this->ngo->name,
            'food_title' => $this->food->title,
            'food_id'    => $this->food->id,
            'ngo_id'     => $this->ngo->id,
        ];
    }
}
