<?php

include __DIR__ .'/vendor/autoload.php';

use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\User\Game;
use Discord\Voice\VoiceClient;
use Discord\WebSockets\Event;
use Discord\Factory\Factory;

$discord = new Discord([
    'token' => 'MjE1MDExOTkyMjc1MTI0MjI1.CpRVDg.soJg8TeV0NvyhemtFNxkdrBH4_A',
    'loadAllMembers' => true,
    'logging' => true,
]);

$discord->on('ready', function ($discord) {
    echo "Bot is ready!", PHP_EOL;
    // Listen for messages.
    $discord->on('message', function ($message, $discord) {
        echo "New Messsage from {$message->author->username},\nSever Name: {$message->channel->guild->name},\nChannel name: {$message->channel->name},\nUser: {$message->author->username},\nMessage: {$message->content}\n\r",PHP_EOL;
        if($message->content == "ping"){
             $message->channel->sendMessage("pong");
        }
        if($message->content == "/ping"){
            $message->reply("pong");
            echo "Bot replyed pong to: {$message->author->username}!", PHP_EOL;
            // echo $message->channel, PHP_EOL;
        }
        if($message->content == "/test"){
            $message->channel->sendMessage("this is a test from {$message->author->username}!", true);
        }
		if($message->content === "/cleenup" && $message->author->username === "duncte123"){
			$channel = $message->channel;
			$channel->getMessageHistory(["limit" => 50])->then(function ($messages) use ($channel) {
				$channel->deleteMessages($messages);
			})->otherwise(function (\Exception $e) {
				echo "There was an error getting the message history: {$e->getMessage()}";
			});
			$message->channel->sendMessage("50 messages cleared!");
		}else if($message->content === "/cleenup" && $message->author->username != "duncte123"){
			$message->reply("you don't have permission to use this command!");
		}
        if(strpos($message->content, 'back') !== false){
            $message->channel->sendMessage("wb {$message->author->username}!");
        }
        if(strpos($message->content, 'gtg') !== false){
            $message->channel->sendMessage("cya {$message->author->username}!");
        }

        if(strpos( strtolower($message->content), 'kys') !== false){
            $message->channel->sendMessage("please don't say things like that {$message->author->username}.");
        }
        /*if($message->content == "/playmeasong"){

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
            $discord->joinVoiceChannel($authorChannel)->then(function (VoiceClient $vc)  {
                $vc->setVolume(10);
                $vc->setFrameSize(40)->then(function () use ($vc) {
                    $vc->playFile('./test.mp3')->then(function () use ($vc) {
                        $vc->close();
                    }, function (\Exception $e) {
                        echo "There was an error sending the mp3: {$e->getMessage()}";
                    });
                });
            }, function ($e) {
                echo "There was an error joining the voice channel: {$e->getMessage()}";
            });
            $message->channel->sendMessage("playing a song for {$message->author->username}");
        }*/
        //the help command
        if($message->content == "/help"){
            $message->channel->sendMessage("here are the commands that can be used on this server: ");
            $message->channel->sendMessage("/help => shows this page");
        }

    });
    /*$discord->joinVoiceChannel($channel)->then(function (VoiceClient $vc) {
        echo "Joined voice channel.\r\n";
        $vc->playFile('myfile.mp3');
    }, function ($e) {
        echo "There was an error joining the voice channel: {$e->getMessage()}\r\n";
    });*/
    // when a new member joins
    $discord->on(Event::GUILD_MEMBER_ADD, function ($member) {
        echo "==========================",PHP_EOL;
        echo "new member ({$member->username})",PHP_EOL;
        //sendMessage("{$member->username}, welcome to the Skyblock online discord server!");
        $role = $member->guild->roles->get('id', '207416066953969666'); // get the role through a guild etc.
        // $role = $member->guild->roles->get('name', '@Member (nature, winter)');
        if($member->addRole($role)){
            echo "adding role: {$role->name}", PHP_EOL;
        }
        /*if($member->guild->members->save($member)){
            // echo "role {$role->name} added", PHP_EOL;
            echo "role added", PHP_EOL;
        }*/
		$member->guild->members->save($member)->then(function ($member) {
			 echo "role added", PHP_EOL;
		}, function ($e) {
			echo $e->getMessage();
		});
        echo "==========================",PHP_EOL;
        // $member->guild->channel->sendMessage("welcome {$member->username}, to the Skyblock online discord server!");
		// $member->guild->channels->getAll('type', Discord\Parts\Channel\Channel::TYPE_TEXT)->first()->sendMessage("welcome {$member->username}, to the Skyblock online discord server!");
		$member->guild->channels->getAll('type', Channel::TYPE_TEXT)->first()->sendMessage("welcome {$member->username}, to the Skyblock online discord server!");
    });

    //$discord->guild->channels->getAll('type', Channel::TYPE_TEXT)->first()->sendMessage("Bot is ready use /help for a list of commands.");

});

$discord->run();
