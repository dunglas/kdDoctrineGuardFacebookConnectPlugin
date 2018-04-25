<?php

/*
 * (c) Kévin Dunglas <dunglas@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
use Facebook\Facebook;

/**
 * <code>Facebook</code> singleton.
 *
 * @package kdDoctrineGuardFacebookConnectPlugin
 * @subpackage config
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class kdDoctrineGuardFacebookConnect {

    /**
     * @var Facebook The <code>Facebook</code> instance
     */
    protected static $facebook = null;

    /**
     * Returns a Facebook api instance.
     *
     * @return Facebook The instance
     */
    public static function getFacebook() {
        if (null === self::$facebook) {
            self::$facebook = new Facebook(array(
                'app_id' => sfConfig::get('app_facebook_appId'),
                'app_secret' => sfConfig::get('app_facebook_secret'),
                'cookie' => sfConfig::get('app_facebook_cookie'),
            ));
        }

        return self::$facebook;
    }

    /**
     * Updates or creates a sfGuardUser for the logged in Facebook usser
     *
     * @param array $me
     * @param string $token
     *
     * @return sfGuardUser
     */
    public static function updateOrCreateUser(array $me, $token) {
        $newUser = false;

        if ($me['email']) {
            $email = $me["email"];
            $sfGuardUser = Doctrine_Core::getTable('sfGuardUser')->findOneByEmailAddress($email);
        }
        else {
            srand();
            $email = "undefined_" + rand(10000);
        }
        if (!$sfGuardUser) {
            // Try by Facebook ID
            $sfGuardUser = Doctrine_Core::getTable('sfGuardUser')->findOneByFacebookId($me['id']);
        }
        if (!$sfGuardUser) {
            $sfGuardUser = new sfGuardUser();
            $sfGuardUser->setUsername($email);
            $sfGuardUser->setEmailAddress($email);
            $sfGuardUser->is_active = true;

            $newUser = true;
        }

        $sfGuardUser->setFacebookId($me['id']);
        $sfGuardUser->setFacebookLink($me['link']);
        $sfGuardUser->setFirstName($me['first_name']);
        $sfGuardUser->setLastName($me['last_name']);
        $sfGuardUser->setFacebookVerified($me['verified']);
        $sfGuardUser->setLocation($me['location']['name']);
        $sfGuardUser->setFacebookLocationId($me['location']['id']);
        $sfGuardUser->setGender($me['gender']);
        $sfGuardUser->setLocale($me['locale']);
        $sfGuardUser->setTimezone($me['timezone']);
        $sfGuardUser->setLastLogin(date('Y-m-d H:i:s'));

        $sfGuardUser->save();

        // Si no es una empresa ni una persona, creamos permisos de persona
        if (
            (!$sfGuardUser->Empresa || !$sfGuardUser->Empresa->id)
            && (!$sfGuardUser->Persona || !$sfGuardUser->Persona->id)
        ){
            $persona = new Persona();
            $persona->usuario_id = $sfGuardUser->id;
            $persona->save();

            sfGuardUserPermission::newUserPermission($sfGuardUser, "persona");
        }

        if ($newUser){
            self::publishRegister($sfGuardUser, $token);
            sfContext::getInstance()->getUser()->setFlash("facebookRegister", true);
        } else {
            // Para evitar un error al guardar al usuario autenticado vía Facebook
            sfContext::getInstance()->getUser()->setFlash("facebookLogin", true);

        }

        return $sfGuardUser;
    }

    /**
     * Publica en Facebook
     *
     * @param string $message
     * @param string $token
     */
    private static function publish($message, $token){
        //if (sfConfig::get("sf_environment") != "dev"){

        $facebook = self::getFacebook();
        $metaData = $facebook->getOAuth2Client()->debugToken($token);

        if ($metaData->getUserId()){
            try{
                $facebook->post(
                    '/'.$metaData->getUserId().'/feed',
                    array(
                        "message" => $message,
                        "link" => "http://www.chambeando.mx",
                        "actions" => json_encode(array(array("name" => "Regístrate en Chambeando", "link" => "http://www.chambeando.mx")))
                    ),
                    $token
                );

            } catch(FacebookApiException $e){
                die("ERROR: " . $e->getMessage());
                Util::logError("Error publishing in Facebook.  Type: ".$e->getType()." - Message: ".$e->getMessage());
            }
        }

        //}
    }

    public static function publishRegister(sfGuardUser $guard_user, $token){
        $message = $guard_user->getName()." se ha registrado en Chambeando.mx";

        self::publish($message, $token);
    }

    public static function getLogoutUrl(){
        $facebook = self::getFacebook();

        $url = sfContext::getInstance()->getRouting()->generate('sf_guard_signout', array(), true);

        if ($facebook->getUser()){

            //if ($facebook->getSession()) {
            if ($facebook->getUser()){
                $url = $facebook->getLogoutUrl(array (
                    'next' => $url
                ));
            }
        }

        return $url;
    }
}
