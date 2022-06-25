<?php

namespace Deployer;

require 'recipe/statamic.php';

// Config

$repository = 'https://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@github.com/insight-media/...';
$host = '';
$user = '';
$deployPath = '';

set('repository', $repository);
//set('http_user', $user);
set('writable_mode', 'chmod');
set('update_code_strategy', 'clone');
set('current_branch', trim(implode('/', array_slice(explode('/', file_get_contents('.git/HEAD')), 2))));

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host($host)
    ->setHostname($host)
    ->setRemoteUser($user)
    ->setDeployPath($deployPath);

// Tasks

desc('Set git remote origin on host');
task('set-origin', function () {
    cd('{{release_or_current_path}}');
    run('git remote set-url origin '.get('repository'));
});

desc('Upload .env.{{current_branch}} to host');
task('upload-env', function () {
    upload('.env.'.get('current_branch'), get('deploy_path').'/shared/.env');
});

desc('Download public storage folder');
task('download-public-storage', function () {
    download(get('deploy_path').'/shared/storage/app/public', 'storage/app/public');
});

after('deploy', 'set-origin');
after('deploy:failed', 'deploy:unlock');
