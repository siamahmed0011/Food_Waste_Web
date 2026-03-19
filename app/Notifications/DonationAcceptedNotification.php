<?php

namespace App\Notifications;

use App\Models\FoodPost;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DonationAcceptedNotification extends Notification
{
    use Queueable;

    public $ngoUser;
    public $food;

    public function __construct(User $ngoUser, FoodPost $food)
    {
        $this->ngoUser = $ngoUser;
        $this->food    = $food;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'ngo_name'   => $this->ngoUser->name,
            'food_title' => $this->food->title,
            'food_id'    => $this->food->id,
            'ngo_id'     => $this->ngoUser->id,
        ];
    }
}