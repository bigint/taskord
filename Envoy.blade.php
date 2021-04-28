@servers(['web' => '127.0.0.1'])

@task('deploy', ['on' => 'web'])
    git pull origin main
    composer install --no-progress
    composer dump-autoload
    yarn install
    yarn production
    php artisan app:clean
@endtask
