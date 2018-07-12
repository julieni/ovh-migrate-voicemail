<?php

require __DIR__ . '/vendor/autoload.php';
use \Ovh\Api;

$rights = [
    'GET=/telephony',
    'GET=/telephony/*/voicemail',
    'GET=/telephony/*/voicemail/*',
    'POST=/telephony/*/voicemail/*/migrateOnNewVersion'
];

$config_file = __DIR__.'/config.ini';
if(!file_exists($config_file)){
    file_put_contents($config_file, join("\n", ['AK = ','AS = ','CK = ']));
    echo 'Config file initialized',"\n";
    echo 'Go to this URL and update config.ini file.',"\n",'https://api.ovh.com/createToken/?'.join('&', $rights)."\n";
    exit;
}
$config = parse_ini_file($config_file);
if(!$config || !$config['AK'] || !$config['AS'] || !$config['CK']){
    echo 'Config not set',"\n";
    echo 'Go to this URL and update config.ini file.',"\n",'https://api.ovh.com/createToken/?'.join('&', $rights)."\n";
    exit;
}

$limit = $argv[1] ?? null;
$count = 0;

set_time_limit(0);

$ovh = new Api($config['AK'], $config['AS'], 'ovh-eu', $config['CK']);
foreach($ovh->get('/telephony') as $group){
    echo $group,"\n"; 
    foreach($ovh->get('/telephony/'.$group.'/voicemail') as $voicemail_id){
        $voicement_settings = (object) $ovh->get('/telephony/'.$group.'/voicemail/'.$voicemail_id.'/settings');
        if($voicement_settings->isNewVersion){
            echo ' - ',$voicemail_id,' : migrated',"\n";
        }
        else{
            $ovh->post('/telephony/'.$group.'/voicemail/'.$voicemail_id.'/migrateOnNewVersion');
            echo ' - ',$voicemail_id,' : migrating now',"\n";
            $count++;
            if($limit && $count == $limit)
                break 2;
        }
    }
    echo "\n";
}
