<?php
//ini_set('memory_limit', '-1'); // REMOVING PHP MEMORY LIMIT

include __DIR__ . '/vendor/autoload.php';

use Discord\Bot\Bot;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Voice\VoiceClient;

$bot = new Bot([
    'bot-token' => 'bot-token',
    'prefix' => '/',
    'name' => 'test bot',
    'playing' => 'a game'
]);
$bot->on('ready', function ($config, $discord, Bot $bot) {
    $bot->getLogger()->addInfo('Bot is running.', [
        'user' => "{$discord->username}#{$discord->discriminator}",
        'prefix' => $config['prefix'],
    ]);
    $bot->getLogger()->addNotice("Connected to " . count($discord->guilds) . " servers");
});

$bot->addCommand('leeroy', function ($params, Message $message, Bot $bot, Discord $discord) {
    $guild = $message->channel->guild;

    $channels = $guild->channels->getAll("type", Channel::TYPE_VOICE);

    $found = false;
    $authorChannel = null;
    foreach ($channels as $channel) {
        if (isset($channel->members[$message->author->id])) {
            $authorChannel = $channel;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $message->reply('```Please join a voice channel to use this command.```');
        return;
    }

    $discord->joinVoiceChannel($authorChannel)->then(function (VoiceClient $vc) use ($bot) {
        $vc->setVolume(10);
        $vc->setFrameSize(40)->then(function () use ($vc, $bot) {
            $vc->playFile('./audio/leeroy.mp3')->then(function () use ($vc) {
                $vc->close();
            }, function (\Exception $e) use ($bot) {
                $bot->getLogger()->addInfo("There was an error sending the mp3: {$e->getMessage()}");
            });
        });
    }, function (\Exception $e) use ($bot) {
        $bot->getLogger()->addInfo("There was an error joining the voice channel: {$e->getMessage()}");
    });
});

$bot->addCommand('coin', function ($params, Message $message, Bot $bot, Discord $discord) {
    $images = ["heads.png", "tails.png"];
    $result = $images[rand(0, 1)];

   $message->channel->sendMessage($result)->then(function ($response) use ($bot) {
        $bot->getLogger()->addInfo("The message was sent!");
    })->otherwise(function (\Exception $e) use ($bot) {
        $bot->getLogger()->addInfo("There was an error sending the message: {$e->getMessage()}");
    });

    // Currently broken. Uncomment if this is fixed
    /*$message->channel->sendFile("./image/coin/{$result}", $result, $result, false)->then(function ($response) use ($bot) {
        $bot->getLogger()->addInfo("The file was sent!");
    })->otherwise(function (\Exception $e) use ($bot) {
        $bot->getLogger()->addInfo("There was an error sending the file: {$e->getMessage()}");
    });*/
});

$bot->start();
