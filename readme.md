# Facebook Connect for symfony and sfGuard

_kdDoctrineGuardFacebookConnectPlugin_ provides an easy way to sign into a symfony 1 application using a Facebook account.
It extends [_sfDoctrineGuardPlugin_](http://www.symfony-project.org/plugins/sfDoctrineGuardPlugin). 

## Installation

* Install and configure [_sfDoctrineGuardPlugin_](http://www.symfony-project.org/plugins/sfDoctrineGuardPlugin) 
* Install _kdDoctrineGuardFacebookConnectPlugin_
  
  ```sh
  # Example using git
  git submodule add http://github.com/dunglas/kdDoctrineGuardFacebookConnectPlugin.git plugins/kdDoctrineGuardFacebookConnectPlugin
  ```
  
* Create [your Facebook application](http://www.facebook.com/developers/)
* Enable the plugin in the `config/ProjectConfiguration.class.php` file after _sfDoctrineGuardPlugin_.

  ```php
  class ProjectConfiguration extends sfProjectConfiguration {
    public function setup()
    {
      $this->enablePlugins('sfDoctrinePlugin');
      $this->enablePlugins('sfDoctrineGuardPlugin');
      $this->enablePlugins('kdDoctrineGuardFacebookConnectPlugin');
    }
  }
  ```
      
* Rebuild your database and classes

  ```sh
  php symfony doctrine:build --all --and-load
  ```

* Edit `app.yml` to match your Facebook application settings

  ```yaml
  all:
    facebook:
    appId:                  xxx   # Your app id
    secret:                 yyy   # Your app secret
    cookie:                 true  # Use cookie
    script_lang:            en_US # Facebook UI language
  ```

* Edit `filters.yml` to enable the FacebookConnect filter

  ```yaml
  rendering: ~
  security:  ~
  
  # Facebook Connect
  facebook:
    class: kdDoctrineGuardFacebookConnectFilter
  
  # Remember me
  remember_me:
    class: sfGuardRememberMeFilter
  
  # insert your own filters here
  
  cache:     ~
  execution: ~
  ```
      
* Enable the _kdGuardAuthFacebookConnect_ module and set is a signin module in `settings.yml`

  ```yaml
  all:
    .settings:
      # ...
      enabled_modules:        [default, sfGuardAuth, kdGuardAuthFacebookConnect]
  
      login_module:           kdGuardAuthFacebookConnect
      login_action:           signin
  ```
        

* Add the Facebook Login button JavaScript before the body end tag in your app's layout

  ```php
  ...
  <?php include_slot('fb_connect') ?>
  </body>
  ...
  ```

* Update your templates to use the route `kd_guard_signin` for signin and `kd_guard_signout` for logout instead of the sfDoctrineGuard default routes
* Clear the cache with `php symfony cc` and enjoy!