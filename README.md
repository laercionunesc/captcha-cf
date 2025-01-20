# CaptchaCf Turnstile CloudFlare plugin for CakePHP 3.x

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require laercionunesc/captcha-cf
```

followed by the command:

```
composer update
```

## Load plugin

From command line:
```
bin/cake plugin load CaptchaCf
```

OR load in config/bootstrap.php
```
Plugin::load('CaptchaCf', ['bootstrap' => false, 'autoload' => true]);
```

## Load Component and Configure

Override default configure from loadComponent in Controller:
```
$this->loadComponent('CaptchaCf.CaptchaCf', [
    'enable' => true,
    'sitekey' => 'key-public', // get credentials in https://developers.cloudflare.com/turnstile/get-started/#existing-sites
    'secret' => 'key-secret',
    'size' => 'flexible',
    'theme' => 'auto',
    'language' => 'en'
]);
```
## Usage

Display Captcha Turnstile in your view:
```
    <?= $this->Form->create() ?>
    <?= $this->Form->control('username') ?>
    <?= $this->Form->control('password') ?>
    <?= $this->CaptchaCf->display() ?>  // Display Captcha Turnstile box in your view, if configure has enable = false, nothing will be displayed
    <?= $this->Form->button() ?>
    <?= $this->Form->end() ?>
```

Verify in your controller function
```
    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->CaptchaCf->verify()) { // if configure enable = false, it will always return true
                //do something here
            }
            $this->Flash->error(__('Please pass Turnstile first'));
        }
    }
```

Done!
