<?php
/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Connects plugins routes.
 * 
 * @package kdDoctrineGuardFacebookConnectPlugin
 * @subpackage routing
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class kdDoctrineGuardFacebookConnectRouting
{
  /**
   * Adds routes for the kdGuardAuthFacebookConnect plugin.
   * 
   * @param sfEvent $event 
   */
  static public function addRouteForkdGuardAuthFacebookConnect(sfEvent $event)
  {
    $r = $event->getSubject();

    $r->prependRoute('kd_guard_signin', new sfRoute('/guard/fb_signin', array('module' => 'kdGuardAuthFacebookConnect', 'action' => 'signin')));
    $r->prependRoute('kd_guard_signout', new sfRoute('/guard/fb_signout', array('module' => 'kdGuardAuthFacebookConnect', 'action' => 'signout')));
  }
}