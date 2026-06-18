<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registration;
use App\Models\ChatRoom;

class CreateChatRooms extends Command
{
    protected $signature   = 'chat:create-rooms';
    protected $description = 'Buat chat room untuk semua registrasi yang sudah confirmed';

    public function handle()
    {
        $regs = Registration::with('event.organizationProfile')
            ->where('status', 'confirmed')
            ->get();

        $count = 0;

        foreach ($regs as $reg) {
            if (!$reg->event || !$reg->event->organizationProfile) continue;

            $organizerId = $reg->event->organizationProfile->user_id;

            ChatRoom::firstOrCreate(
                ['registration_id' => $reg->id],
                [
                    'event_id'     => $reg->event_id,
                    'volunteer_id' => $reg->user_id,
                    'organizer_id' => $organizerId,
                    'is_open'      => true,
                ]
            );

            $count++;
        }

        $this->info("Selesai! $count chat room berhasil dibuat.");
    }
}