<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced and Slightly Optimized Template</h1>
    <br>
</p>

[![Latest Stable Version](https://img.shields.io/packagist/v/pa3py6aka/yii2-advanced-optimized.svg)](https://packagist.org/packages/pa3py6aka/yii2-advanced-optimized)
[![Total Downloads](https://img.shields.io/packagist/dt/pa3py6aka/yii2-advanced-optimized.svg)](https://packagist.org/packages/pa3py6aka/yii2-advanced-optimized)
[![Build Status](https://travis-ci.org/pa3py6aka/yii2-advanced-optimized.svg?branch=master)](https://travis-ci.org/pa3py6aka/yii2-advanced-optimized)

Yii 2 Advanced Optimized Project Template is the fork of Yii2 Advanced template.

<h3>Note:</h3>
This is alpha version of template. All contributings are welcome!

<h3>Whats new</h3>
 - Uses Bootstrap 4
 - Authorization forms in modal blocks with ajax validation
 - Authorization by social networks using `yiisoft/yii2-authclient`
 - Default RBAC. Uses three roles - `user`, `moderator`, `admin`. 
   User can manage his content, moderator can manage all users content, admin has moderators access.
   You can apply to admins more privileges. Manage it in `console/controllers/RbacController.php`.
   After changes, execute `php yii rbac/init` command in the terminal (of course you must be in project directory).
 - [IDE autocompletion for custom components](https://github.com/samdark/yii2-cookbook/blob/master/book/ide-autocompletion.md#ide-autocompletion-for-custom-components)
 - Added frontend and backend url manager components. And url rules moves in separates files.
 - Tabler template for backend on Bootstrap 4 ([Tabler](https://github.com/tabler/tabler))
 - ... 

<h3>Installation</h3>
By Composer:

    composer create-project --prefer-dist pa3py6aka/yii2-advanced-optimized my-new-application

The command installs the project in a directory named `my-new-application`. You can choose a different
directory name if you want.

Open a console terminal, execute the `init` command and select `dev` as environment.

   ```
   /path/to/php-bin/php /path/to/yii-application/init
   ```

Create a new database and adjust the `components['db']` configuration in `/path/to/yii-application/common/config/main-local.php` accordingly.

Open a console terminal, apply migrations with command `/path/to/php-bin/php /path/to/yii-application/yii migrate`.

Initialize RBAC:
   ```
   /path/to/php-bin/php /path/to/yii-application/yii rbac/init
   ```
Create Administrator user:
   Sign up on frontend site, then go to console and assign `admin` role to created user:
   ```
   /path/to/php-bin/php /path/to/yii-application/yii roles/assign
   ```
<h3>Contributing</h3>   
<div align="center"><b>All contributings are welcome!</b></div>