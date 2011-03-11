<?php
require_once(dirname(__FILE__).'/../../../../sfDoctrineGuardPlugin/modules/sfGuardAuth/actions/actions.class.php');


/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class kdGuardAuthFacebookConnectActions extends sfGuardAuthActions {
  public function executeSignout($request) {
    $facebook = kdDoctrineGuardFacebookConnect::getFacebook();
    
    $url = $this->getContext()->getRouting()->generate('sf_guard_signout', array(), true);
    
    if ($facebook->getSession()) {
      $url = $facebook->getLogoutUrl(array (
        'next' => $url
      ));
    }
    
    $this->redirect($url);
  }
}
