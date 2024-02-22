<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/DDAW-PROYECTO-BORSA/API.git');

add('shared_files', ['.env', 'docker-compose.yml']);
add('shared_dirs', ['storage', 'public/uploads', 'node_modules']);
add('writable_dirs', ['bootstrap/cache', 'storage']);


// Hosts

host('54.235.37.231')
    ->set('remote_user', 'deployer')
    ->set('ssh_multiplexing', false)
    ->set('identityFile', 'C:\Users\HECTOR\.ssh\id_rsa')
    ->set('deploy_path', '/var/www/borsabatoi/html/');
// Hooks

after('deploy:failed', 'deploy:unlock');


after('deploy:failed', 'deploy:unlock');

task('upload:env', function () {
    upload('.env.production', '{{deploy_path}}/shared/.env');
   })->desc('Environment setup');
   

      

# Declaració de la tasca
task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php8.1-fpm restart');
   });
   # inclusió en el cicle de desplegament
   after('deploy', 'reload:php-fpm');


task('composer:install', function () {
    run('composer --working-dir=/var/www/borsabatoi/html/current install');
});