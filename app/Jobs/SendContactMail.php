<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendContactMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function handle()
    {
        try {
            $emailData = [
                'name' => $this->mailData['name'],
                'email' => $this->mailData['email'],
                'phone' => $this->mailData['phone'],
                'content' => $this->mailData['message']
            ];

            Mail::send('emails.contact', $emailData, function ($message) {
                $message->to('duynguyen.joy@gmail.com')
                        ->subject('Yêu cầu liên hệ từ website');

                $message->from(
                    config('mail.from.address'),
                    config('mail.from.name')
                );
            });

            Log::info('Mail đã gửi xong từ Queue');
        } catch (\Throwable $e) {
            Log::error('LỖI GỬI MAIL TỪ QUEUE', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Nếu fail quá nhiều lần, job sẽ tự động vào bảng failed_jobs
            throw $e;
        }
    }
}