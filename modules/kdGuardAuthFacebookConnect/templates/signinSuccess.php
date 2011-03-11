<?php use_helper('I18N') ?>

<h1><?php echo __('Signin', null, 'sf_guard') ?></h1>

<?php echo get_partial('kdGuardAuthFacebookConnect/signin_form', array('form' => $form, 'facebook' => $facebook)) ?>