<?php use_helper('I18N') ?>
<?php slot('fb_connect') ?>
<div id="fb-root"></div>
<script type="text/javascript">
  /* <![CDATA[ */
  window.fbAsyncInit = function() {
    FB.init({
      appId   : '<?php echo $facebook->getAppId(); ?>',
      status  : true,
      cookie  : true,
      xfbml   : true
    });

    // whenever the user logs in, we refresh the page
    FB.Event.subscribe('auth.login', function() {
      window.location.reload();
    });
  };

  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/<?php echo sfConfig::get('app_facebook_script_lang') ?>/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());
  /* ]]> */
</script>
<?php end_slot() ?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <table>
    <tbody>
      <?php echo $form ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="<?php echo __('Signin', null, 'sf_guard') ?>" />

    <fb:login-button<?php if (sfConfig::get('app_facebook_perms'))
        echo ' perms="' . sfConfig::get('app_facebook_perms') . '"' ?>></fb:login-button>

    <?php $routes = $sf_context->getRouting()->getRoutes() ?>
    <?php if (isset($routes['sf_guard_forgot_password'])): ?>
      <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
    <?php endif; ?>

    <?php if (isset($routes['sf_guard_register'])): ?>
      &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'sf_guard') ?></a>
<?php endif; ?>
    </td>
    </tr>
    </tfoot>
  </table>
</form>