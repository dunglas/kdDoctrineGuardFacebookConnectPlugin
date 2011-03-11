<?php
/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once(dirname(__FILE__).'/../../../../sfDoctrineGuardPlugin/modules/sfGuardAuth/actions/components.class.php');

/**
 * Components.
 * 
 * @package kdDoctrineGuardFacebookConnectPlugin
 * @subpackage actions
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class BasekdGuardAuthFacebookConnectComponents extends sfGuardAuthComponents {

  public function executeSignin_form()
  {
    $this->facebook = kdDoctrineGuardFacebookConnect::getFacebook();

    parent::executeSignin_form();
  }
}