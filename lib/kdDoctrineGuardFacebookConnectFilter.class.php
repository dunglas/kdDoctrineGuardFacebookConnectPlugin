<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Logs or registers automatically Facebook connected users.
 * 
 * @package kdDoctrineGuardFacebookConnec
 * @subpackage lib
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class kdDoctrineGuardFacebookConnectFilter extends sfFilter {
  /**
   * Executes the filter and chains.
   * 
   * @param sfFilterChain $filterChain 
   */
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
            $sfGuardUser = kdDoctrineGuardFacebookConnect::updateOrCreateUser($me);

            $this->context->getUser()->signIn($sfGuardUser);
          }
        } catch (FacebookApiException $ex) {
          $this->getContext()->getLogger()->err($ex);
        }
      }
    }

    $filterChain->execute();
  }
}