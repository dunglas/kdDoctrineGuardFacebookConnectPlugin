<?php
/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * kdDoctrineGuardFacebookConnectPlugin configuration.
 * 
 * @package kdDoctrineGuardFacebookConnectPlugin
 * @subpackage config
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class kdDoctrineGuardFacebookConnectPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    foreach (array('kdGuardAuthFacebookConnect') as $module)
    {
      if (in_array($module, sfConfig::get('sf_enabled_modules', array())))
      {
        $this->dispatcher->connect('routing.load_configuration', array('kdDoctrineGuardFacebookConnectRouting', 'addRouteFor' . $module));
      }
    }
  }
}
