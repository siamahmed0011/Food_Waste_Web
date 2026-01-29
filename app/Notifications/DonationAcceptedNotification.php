<?php

namespace App\Notifications;

use App\Models\FoodPost;
use App\Models\Ngo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationAcceptedNotification extends Notification
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
     return ['database'];
    }

    public function toArray($notifiable)
    {
    return [
        'ngo_name'   => $this->ngo->name,
        'food_title' => $this->food->title,
        'food_id'    => $this->food->id,
        'ngo_id'     => $this->ngo->id,
     ];
    }

}
