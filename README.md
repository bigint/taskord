<div align="center">
    <p><img src="public/images/logo.svg" height="70" alt="Taskord Logo"></p>
    <h1>Taskord</h1>
    <strong>✅ Get things done in public</strong>
</div>
<br>
<div align="center">
    <a href="https://www.php.net">
        <img src="https://img.shields.io/badge/PHP-v8.0-blue.svg?logo=php" alt="PHP Version">
    </a>
    <a href="http://laravel.com">
        <img src="https://img.shields.io/badge/Laravel-v8.x-important.svg?logo=laravel&longCache=true" alt="Laravel Version">
    </a>
    <a href="https://nodejs.org">
        <img src="https://img.shields.io/badge/Node-v14.x-brightgreen.svg?logo=node.js&longCache=true" alt="Node Version">
    </a>
    <a href="https://gitlab.com/taskord/taskord/-/commits/main">
        <img src="https://gitlab.com/taskord/taskord/badges/main/pipeline.svg" alt="CI">
    </a>
    <a href="https://www.codacy.com/gl/taskord/taskord/dashboard">
        <img src="https://app.codacy.com/project/badge/Grade/346b75b6fa564e16958cc7b6c1b5ce2a"/>
    </a>
    <a href="https://gitpod.io/#https://gitlab.com/taskord/taskord" alt="Codacy">
        <img src="https://img.shields.io/badge/setup-automated-blue?logo=gitpod" alt="GitPod badge">
    </a>
    <a href="LICENSE">
        <img src="https://img.shields.io/badge/license-GNU%20AGPLv3-green?longCache=true" alt="MIT License">
    </a>
    <a href="https://discord.gg/9M4Q65b">
        <img src="https://img.shields.io/discord/742712073670230026.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2" alt="Discord">
    </a>
    <a href="https://twitter.com/taskord">
        <img src="https://img.shields.io/twitter/follow/taskord?label=Follow&style=social" alt="Taskord Twitter">
    </a>
</div>
<div align="center">
    <br>
    <a href="https://taskord.com"><b>taskord.com »</b></a>
    <br><br>
    <a href="https://gitlab.com/taskord/taskord/-/issues/new"><b>Report Bug</b></a>
    •
    <a href="https://gitlab.com/taskord/taskord/-/issues/new"><b>Request Feature</b></a>
</div>

## About Taskord

- **✅ Tasks:** All tasks are public and added to your maker profile.
- **🔥 Reputation:** Earn reputations by completing, praising, and commenting on tasks and questions, which helps you to stay productive.
- **😀 Makers:** Community of peoples who ships constantly.
- **📦 Products:** Ship your products to Taskord and make regular updates about the product and even add tasks to them.
- **💬 Q&A:** Get your questions answered and use this feature as discussion too.
- **🤝 Meetups:** Find or create your own meetup and meet people near you who share your interests.
- **🎁 Deals:** Discounts and special deals for Taskord members. Only available to patrons.

## Prerequisites

- [PHP](https://www.php.net): please refer to their [installation guide](https://www.php.net/manual/en/install.php).
- [Node](https://nodejs.org): we recommend using [nvm](https://github.com/nvm-sh/nvm) to install the Node version listed on the badge.
- [MySQL](http://www.mysql.com) 8.0 or higher.
- [Redis](https://redis.io) (optional) 4.0 or higher.
- [Memcached](https://memcached.org) (optional) 1.6 or higher.

## Contributing

Contributions are what makes the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the project, ie. https://gitlab.com/taskord/taskord/-/forks/new
2. Clone your forked repository, ie. `git clone https://gitlab.com/<your-username>/taskord.git`
3. Create your Feature Branch (`git checkout -b AmazingFeature`)
4. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
5. Push to the Branch (`git push origin AmazingFeature`)
6. Open a Merge Request

Start coding in a [ready-to-code development environment](https://www.gitpod.io):

<a href="https://gitpod.io/#https://gitlab.com/taskord/taskord" style="padding: 10px;">
    <img src="https://gitpod.io/button/open-in-gitpod.svg" width="150" alt="Push" align="center">
</a>

## Standard Installation

1. Make sure all the prerequisites are installed.
2. Set up your environment variables/secrets in the `.env` file
    ```sh
    cp .env.example .env
    ```
3. Create a free [Mailtrap](https://mailtrap.io) account, get your email credentials and fill it in the `.env` file
4. Run the commands below to install Taskord
    ```sh
    # Install Composer Dependencies
    composer install

    # For Windows
    composer install --ignore-platform-reqs

    # Install NPM Dependencies
    npm install / yarn install

    # Build and watch assets for development
    npm run watch / yarn watch

    # Generate Application Key
    php artisan key:generate

    # Migrate and seed the database with fake data
    php artisan migrate:fresh --seed
    ```
5. Run the Laravel Queue with `php artisan queue:work --tries=3` to receive notifications via web and email
6. That's it! Run `php artisan serve` to start the application and head to `http://localhost:8000`
7. Login with the default credentials, username as `admin` and password as `admin`.

### Production Installation

[View Full Production Installation Documentation.](/docs/installation.md)

-----

<br>

<div align="center">
    <img width="250px" src="https://i.imgur.com/yVtUpZa.gif">
    <br>
    <strong>Happy Shipping</strong> 🚀
</div>
