<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

class SetTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:telegram-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set telegram webhook url';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bot = new Api(config('telegram.bots.mybot.token'));
        $bot->setWebhook([
            'url' => config('telegram.bots.mybot.webhook_url'),
            'drop_pending_updates' => true
        ]);

        return Command::SUCCESS;
    }
}
