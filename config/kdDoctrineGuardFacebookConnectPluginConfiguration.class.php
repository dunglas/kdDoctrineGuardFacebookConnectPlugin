<?php
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
