<?php

namespace Deployer;

require 'recipe/statamic.php';

// Config

$repository = 'https://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@github.com/insight-media/...';
$host = '';
$user = '';
$deployPath = '';
$branch = trim(implode('/', array_slice(explode('/', file_get_contents('.git/HEAD')), 2)));

set('repository', $repository);
//set('http_user', $user);
set('writable_mode', 'chmod');
set('update_code_strategy', 'clone');
set('current_branch', $branch);
set('ssh_multiplexing', false);

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host($host)
    ->setHostname($host)
    ->setRemoteUser($user)
    ->setDeployPath($deployPath)
    ->set('branch', $branch);

// Tasks

desc('Set git remote origin on host');
task('set-origin', function () {
    cd('{{release_or_current_path}}');
    run('git remote set-url origin '.get('repository'));
});

desc('Build assets');
task('build-assets', function () {
    cd('{{release_or_current_path}}');
    run('yarn && yarn build');
    run('chmod -R 775 ./public/build');
});

desc('Symlink public folder to new release');
task('symlink-public', function () {
    run('rm -f -r ~/www');
    run('ln -s {{release_path}}/public/ ~/www');
});

desc('Reload PHP service and clear opcache');
task('reload-php', function () {
    run('reloadPHP.sh');
});

desc('Clear cache');
task('clear-cache', function () {
    cd('{{release_or_current_path}}');
    run('php artisan cache:clear');
    run('php artisan clear-compiled');
    run('php please stache:clear');
});

desc('Warm stache');
task('warm-stache', function () {
    cd('{{release_or_current_path}}');
    run('php please stache:warm');
});

desc('Commit and push current branch on remote host to origin repository');
task('git-commit', function () {
    cd('{{release_or_current_path}}');
    run('php please git:commit');
});

desc('Configure remote server');
task('configure-remote', function () {
    // Copy git binary to user account
    run('mkdir ~/bin');
    run('cp -n /bin/git ~/bin/git');

    // Add cronjob
    run("grep '/please git:commit' /etc/crontab || echo '* * * * * php \$HOME/current/please git:commit >/dev/null 2>&1' >> \$HOME/.crontab");
});

desc('Upload .env.{{current_branch}} to host');
task('upload-env', function () {
    upload('.env.'.get('current_branch'), get('deploy_path').'/shared/.env');
});

desc('Download public storage folder');
task('download-public-storage', function () {
    download(get('deploy_path').'/shared/storage/app/public', 'storage/app');
});

after('deploy', 'set-origin');
after('deploy', 'build-assets');
after('deploy', 'symlink-public');
after('deploy', 'reload-php');
after('deploy', 'clear-cache');
after('deploy', 'warm-stache');
after('deploy:failed', 'deploy:unlock');
