<?php
require 'recipe/codeigniter.php';
require 'vendor/deployphp/recipes/recipes/configure.php';
set('keep_releases', 5);

set('shared_files',
    [
        'application/config/config.php'
    ]
);

// CodeIgniter shared dirs
set('shared_dirs', ['application/cache', 'application/logs']);
// CodeIgniter writable dirs
set('writable_dirs', ['application/cache', 'application/logs', 'application/config']);

set('repository', 'https://github.com/phaniso/phpmonitor-frontend.git');

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');
after('deploy', 'deploy:configure');
after('deploy', 'success');

serverList('config/servers.yml');
