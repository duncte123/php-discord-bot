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
  $discord->on('message', function($message, $discord){
    // i like to logg stuff
    // echo "{$message->author->username}: {$message->content} ({$message->channel->name})\n\r",PHP_EOL;
  });
  // when a new member joins
  $discord->on(Event::GUILD_MEMBER_ADD, function ($member) {
    echo "==========================",PHP_EOL;
    echo "new member ({$member->username})",PHP_EOL;
    //sendMessage("{$member->username}, welcome to the Skyblock online discord server!");
    /*$role = $member->guild->roles->get('id', '207416066953969666'); // get the role through a guild etc.
    if($member->addRole($role)){
      echo "adding role: {$role->name}", PHP_EOL;
    }
    $member->guild->members->save($member)->then(function ($member) {
      echo "role added", PHP_EOL;
    }, function ($e) {
      echo $e->getMessage();
    });*/
    echo "==========================",PHP_EOL;
    // $member->guild->channels->getAll('type', Channel::TYPE_TEXT)->first()->sendMessage("welcome {$member->username}, to the Skyblock online discord server!");

    $textChannels = $member->guild->channels->getAll('type', Channel::TYPE_TEXT);
    foreach ($textChannels as $channel) {
      if($channel->id === "213704348742582283"){return;}
      if($channel->id === "211842550305128450"){return;}
      $channel->sendMessage("welcome {$member->username}, to the Skyblock online discord server!");
    }
  });
  foreach($discord->guilds as $guild) {
    //$textChannels = $guild->channels->getAll('type', Channel::TYPE_TEXT)->first()->sendMessage("SkyBot V{$config['version']} is ready for action!");
    // foreach ($textChannels as $channel) {
    //   if($channel->id === "213704348742582283"){return;}
    //   if($channel->id === "211842550305128450"){return;}
    //   $channel->sendMessage("SkyBot V{$config['version']} is ready");
    // }
  }

});

$bot->addCommand("help", function($params, Message $message, Bot $bot, Discord $discord){
  // $message->channel->sendMessage("```here are the commands that can be used on this server:\n/help => shows this page\n/trigger => use when you are triggered\n/mineh => HERE IS MINEH\n/dankWeed => ignore this one\n/coin => flips a coin\n/cat => gives you a random cat picture ```");
  $user = $discord->users->get('id', $message->author->id);
  $user->sendMessage("```here are the commands that I have build in:\n/help => shows this page\n/trigger => use when you are triggered\n/spam => i like spam!\n/mineh => HERE IS MINEH\n/dankeed => ignore this one\n/java_is_good => just to make _DuB_ happy\n/wam => get more dedotated wam!\n/coin => flips a coin\n/cat => gives you a random cat picture ```")->then(function ($response) use ($message, $bot) {
      $message->reply("check your DM's");
  })->otherwise(function (\Exception $e) use ($bot, $message) {
    $bot->getLogger()->addInfo("There was an error sending the message: {$e->getMessage()}");
    $message->channel->sendMessage("There was an error sending the message: {$e->getMessage()}");

  });
  // new stuff
  // $guild = $discord->guilds->get('id', '162820460164284417');
  // $general = $guild->channels->get('id', '162820460164284417');
  // $general->message("the message");


});

$bot->addCommand("trigger", function($params, Message $message, Bot $bot, Discord $discord){
  $message->channel->sendMessage("https://cdn.discordapp.com/attachments/94831883505905664/176181155467493377/triggered.gif");
});

$bot->addCommand("spam", function($params, Message $message, Bot $bot, Discord $discord){
  $message->channel->sendMessage("https://cdn.discordapp.com/attachments/191245668617158656/216896372727742464/spam.jpg");
});

$bot->addCommand("mineh", function($params, Message $message, Bot $bot, Discord $discord){
  // $message->channel->sendMessage("https://cdn.discordapp.com/attachments/204540634478936064/213983832087592960/20160813133415_1.jpg");
  $message->channel->sendMessage("watch out for mineh, he will destroy your minecraft server", true)->then(function ($response) use ($bot, $message) {
    $bot->getLogger()->addInfo("mineh was sent!");
    $message->channel->sendMessage("https://cdn.discordapp.com/attachments/204540634478936064/213983832087592960/20160813133415_1.jpg");
  })->otherwise(function (\Exception $e) use ($bot) {
    $bot->getLogger()->addInfo("There was an error sending the message: {$e->getMessage()}");
  });
});

// https://cdn.discordapp.com/attachments/203624252295872513/214335018418307073/and-i-dont-care.jpg
$bot->addCommand("dankweed", function($params, Message $message, Bot $bot, Discord $discord){
  $message->channel->sendMessage("https://cdn.discordapp.com/attachments/203624252295872513/214335018418307073/and-i-dont-care.jpg");
});

$bot->addCommand("java_is_good", function($params, Message $message, Bot $bot, Discord $discord){
  $message->channel->sendMessage("https://cdn.discordapp.com/attachments/172645867570987008/212731289428688908/java-anal-sex.jpg");
});

$bot->addCommand("wam", function($params, Message $message, Bot $bot, Discord $discord){
  $message->channel->sendMessage("http://downloadmorewam.com/");
});

$bot->addCommand("cleenup", function($params, Message $message, Bot $bot, Discord $discord){
  // 204546750457839616 => owner role
  /*$role = $message->channel->guild->roles->get('id', '204546750457839616');
  if($message->author->roles->has($role)) {
    $message->channel->sendMessage("Nope");
    echo "yes", PHP_EOL;
  }else{
    $message->channel->sendMessage("you don't have permission n()()b");
    echo "no", PHP_EOL;
  }*/
  if($message->author->username !== "duncte123"){return;}
  $channel = $message->channel;
  $channel->getMessageHistory(["limit" => 50])->then(function ($messages) use ($message, $channel) {
    $channel->deleteMessages($messages);
    $message->channel->sendMessage("50 messages cleared!");
  })->otherwise(function (\Exception $e) {
    echo "There was an error getting the message history: {$e->getMessage()}";
  });
  $channel = null;
});

// add the command /setrank
// has been moved to message content
// no it's not moved PRANK
$bot->addCommand("setrank", function($params, Message $message, Bot $bot, Discord $discord){
  // $message->channel->sendMessage("```php\n{$message->channel}```");
  // this part works
  // check if the arguments are empty
  if(empty($params[0]) || empty($params[1])){
    $message->reply("the correct usage is `/setrank [@username] [rank]`");
    return;
  }
  $user = $message->channel->guild->members->get('id', substr($params[0], 2, strlen($params[0]) - 3));
  if($user->username === $message->author->username){
    $message->reply("nice try, but that's not going to happen");
    return;
  }

  // this part doesn't work
  // checks if the sender of the command has a spific (i don't know how to spell it) role
  if(!$message->author->roles->has('id', '214408581871697921')){
    $message->reply("you are not a staff member.");
    return;
  }
  // all the ranks/roles put in one array
  // member should be set by default
  $ranks = array(
    'member' => '@Member',
    // nature ranks
    'aurora' => '@Aurora',
    'luna' => '@Luna',
    'paladin' => '@Paladin',
    'peridot' => '@Peridot',
    'thorn' => '@Thorn',
    'guardian' => '@Guardian',
    // winter ranks
    'subzero' => '@Subzero',
    'frosty' => '@Frosty',
    'blizzard' => '@Blizzard',
    'artic' => '@Arctic',
    'frostbite' => '@Frostbite',
    'winter' => '@Winter',
  );
  // the user
  $user = $params[0];
  // the rank name
  $rank = $params[1];
  // $user = $message->channel->guild->members->get('name', $user);
  // get the role
  $role = $message->channel->guild->roles->get('name', $ranks[$rank]);
  // get the user
  // $user = $message->channel->guild->members->get('id', substr($params[0], 2, strlen($params[0]) - 3));
  // add the role to the user
  $user->addRole($role);
  // save the user and handle messages
  $user->guild->members->save($user)->then(function ($member) use ($user, $rank, $message) {
    echo "RANK UPDATE: {$user->username} has now the {$rank} rank.", PHP_EOL;
    $message->channel->sendMessage("RANK UPDATE: {$user->username} has now the {$rank} rank.");
  }, function ($e) {
    echo $e->getMessage();
  });
});

$bot->addCommand("test", function($params, Message $message, Bot $bot, Discord $discord){
  $test = $message->channel->guild->roles->get('name', 'can_edit_ranks');//214408581871697921
  echo "{$test}", PHP_EOL;
});

// doesn't work on windows
/*$bot->addCommand('leeroy', function ($params, Message $message, Bot $bot, Discord $discord) {
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
});*/

$bot->addCommand('coin', function ($params, Message $message, Bot $bot, Discord $discord) {
  // $coinUrl = "http://dshelmondgames.r4u.nl/img/coin";
  $coinUrl = "https://dshelmondgames.ml/img/coin";
  $images = ["{$coinUrl}/heads.png", "{$coinUrl}/tails.png"];
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
$bot->addCommand("cat", function($params, Message $message, Bot $bot, Discord $discord){
  // $message->channel->sendMessage("http://random.cat/meow");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, "http://random.cat/meow");
  curl_setopt($ch, CURLOPT_POST, 0);
  // execute the request
  $output = json_decode(curl_exec($ch), true);
  // output the profile information - includes the header
  // var_dump($output);
  // send the cat
  $message->channel->sendMessage($output['file']);
  // close curl resource to free up system resources
  curl_close($ch);
});

$bot->addCommand("rlbot", function($params, Message $message, Bot $bot, Discord $discord){
  for ($i=0; $i < 20; $i++) {
    echo " \n", PHP_EOL;
  }
  exit();
});

$bot->addCommand("bc", function($params, Message $message, Bot $bot, Discord $discord){
  $whatMessage = implode(" ", $params);
  $message->channel->sendMessage("Alert: {$whatMessage}");
  /*foreach($discord->guilds as $guild) {
    $textChannels = $guild->channels->getAll('type', Channel::TYPE_TEXT);
    foreach ($textChannels as $channel) {
      if($channel->id === "213704348742582283"){return;}
      if($channel->id === "211842550305128450"){return;}
      $channel->sendMessage("You can join our minecraft server with the ip: skyblock.online");
    }
  }
  $messages = array(
  "You can join our minecraft server with the ip: skyblock.online",
  "want to know all my commands? use /help"
  );
    //sleep(1200);
    $whatMessage = $messages[rand(0, (count($messages)-1))];
    foreach($discord->guilds as $guild) {
      $textChannels = $guild->channels->getAll('type', Channel::TYPE_TEXT);
      foreach ($textChannels as $channel) {
        if($channel->id === "213704348742582283"){return;}
        if($channel->id === "211842550305128450"){return;}
        $channel->sendMessage("Alert: {$whatMessage}");
      }
    }*/
});


$bot->start();
