<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class kdDoctrineGuardFacebookConnect {

  protected static $facebook = null;

  /**
   * Returns a Facebook api instance
   * 
   * @return Facebook 
   */
  public static function getFacebook()
  {
    if (null === self::$facebook) {
      self::$facebook = new Facebook(array (
            'appId' => sfConfig::get('app_facebook_appId'),
            'secret' => sfConfig::get('app_facebook_secret'),
            'cookie' => sfConfig::get('app_facebook_cookie'),
          ));
    }
            
    return self::$facebook;
  }

}
