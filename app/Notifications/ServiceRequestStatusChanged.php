<?php
// app/Notifications/ServiceRequestStatusChanged.php

namespace App\Notifications;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceRequestStatusChanged extends Notification
{
    use Queueable;

    protected $serviceRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status = $this->serviceRequest->status;
        $title = $this->serviceRequest->title;

        return (new MailMessage)
            ->subject('Service Request Status Updated - FixIt')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your service request status has been updated.')
            ->line('Request: ' . $title)
            ->line('New Status: ' . $status)
            ->action('View Request', route('service-requests.show', $this->serviceRequest))
            ->line('Thank you for using FixIt!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'service_request_id' => $this->serviceRequest->id,
            'status' => $this->serviceRequest->status,
            'title' => $this->serviceRequest->title,
        ];
    }
}