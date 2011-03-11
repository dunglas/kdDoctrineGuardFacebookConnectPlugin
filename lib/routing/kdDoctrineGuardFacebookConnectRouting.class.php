<?php
class kdDoctrineGuardFacebookConnectRouting
{

  static public function addRouteForkdGuardAuthFacebookConnect(sfEvent $event)
  {
    $r = $event->getSubject();

    $r->prependRoute('kd_guard_signout', new sfRoute('/guard/fb_signout', array('module' => 'kdGuardAuthFacebookConnect', 'action' => 'signout')));
    
  }
}