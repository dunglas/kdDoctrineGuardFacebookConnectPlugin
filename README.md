# Facebook Connect for symfony and sfGuard


_kdDoctrineGuardFacebookConnectPlugin_ provides an easy way to sign into a symfony 1 application using a Facebook account.
_kdDoctrineGuardFacebookConnectPlugin_ extends [_sfDoctrineGuardPlugin_](http://www.symfony-project.org/plugins/sfDoctrineGuardPlugin). 

## Installation

* Install _sfDoctrineGuardPlugin_ properly 
* Install _kdDoctrineGuardFacebookConnectPlugin_

      # Example using git
      git submodule add http://github.com/dunglas/kdDoctrineGuardFacebookConnectPlugin.git plugins/kdDoctrineGuardFacebookConnectPlugin

* Create [your Facebook application](http://www.facebook.com/developers/)
* Enable the plugin in the `config/ProjectConfiguration.class.php` file after _sfGuardPlugin_.

      class ProjectConfiguration extends sfProjectConfiguration {
        public function setup()
        {
          $this->enablePlugins('sfDoctrinePlugin');
          $this->enablePlugins('sfDoctrineGuardPlugin');
          $this->enablePlugins('kdDoctrineGuardFacebookConnectPlugin');
        }
      }

* Edit `app.yml` to match your Facebook application settings

      all:
        facebook:
          appId:                  xxx   # Your app id
          secret:                 xxx   # Your app secret
          cookie:                 true  # Use cookie
          script_lang:            en_US # Connect button and JavaScript language

* Edit `filters.yml` to add the FacebookConnect filter

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

* Enable the _kdGuardAuthFacebookConnect_ module and set is a signin module in `settings.yml`

      all:
        .settings:
          # ...
          enabled_modules:        [default, sfGuardAuth, kdGuardAuthFacebookConnect]

          login_module:           kdGuardAuthFacebookConnect
          login_action:           signin

* Clear the cache with `php symfony cc` and enjoy!