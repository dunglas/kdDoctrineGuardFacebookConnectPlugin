<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class kdDoctrineGuardFacebookConnectFilter extends sfFilter {

  public function execute($filterChain)
  {
    if ($this->isFirstCall() && $this->context->getUser()->isAnonymous()) {
      $facebook = kdDoctrineGuardFacebookConnect::getFacebook();
      $session = $facebook->getSession();

      if ($session) {
        $uid = $facebook->getUser();
        try {
          $me = $facebook->api('/me');

          if ($me) {
            $sfGuardUser = Doctrine_Core::getTable('sfGuardUser')->findOneByFacebookUid($uid);
            if (!$sfGuardUser) {
              $sfGuardUser = new sfGuardUser();
              $sfGuardUser->setUsername('Facebook_' . $uid);
              $sfGuardUser->setFacebookUid($uid);
            }

            $sfGuardUser->setFirstName($me['first_name']);
            $sfGuardUser->setLastName($me['last_name']);
            $sfGuardUser->setLocation($me['location']);
            $sfGuardUser->save();

            $this->context->getUser()->signIn($sfGuardUser);
          }
        } catch (FacebookApiException $ex) {
          
        }
      }
    }

    $filterChain->execute();
  }

}