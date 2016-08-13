<?php
//ini_set('memory_limit', '-1'); // REMOVING PHP MEMORY LIMIT

include __DIR__ . '/vendor/autoload.php';

use Discord\Bot\Bot;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\User\User;
use Discord\Parts\User\Game;
use Discord\Voice\VoiceClient;
use Discord\WebSockets\Event;
use Discord\Factory\Factory;

$allowedGuildIds = array(
  "329962158471512075", //DSHelmondGames
  "324453756794175488", //Strand DEV
  "292707924239712258", //Velocity SMP
  "191245668617158656", //duncte123
);

$bot = new Bot([
  'bot-token' => 'MjE1MDExOTkyMjc1MTI0MjI1.CpRVDg.soJg8TeV0NvyhemtFNxkdrBH4_A',
  'prefix' => '/',
  'name' => 'SkyBot',
  'version' => '2.1',
  'playing' => 'SkyBot V2.1|/help'
]);
$bot->on('ready', function ($config, $discord, Bot $bot) {
  $bot->getLogger()->addInfo('Bot is running.', [
    'user' => "{$discord->username}#{$discord->discriminator}",
    'prefix' => $config['prefix'],
    'game' => $config['playing'],
  ]);
  $bot->getLogger()->addNotice("Connected to " . count($discord->guilds) . " servers");
 
  foreach($discord->guilds as $guild) {
    if (!in_array($guild->id, $allowedGuildIds) {
      $guild->channels->getAll('type', Channel::TYPE_TEXT)->first()->sendMessage("The owner of this bot does not allow to you to have this bot in this guild, the bot will leave now.");
    }
    //$textChannels = $guild->channels->getAll('type', Channel::TYPE_TEXT)->first()->sendMessage("SkyBot V{$config['version']} is ready for action!");
  }

});