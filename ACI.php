<?php
/*
Plugin Name: Admin Change Image
Plugin URI: https://nereus-water.com
Description: Plugin réaliser pour NEREUS Water, afin de pouvoir changer le logo dans l'interface de connexion
Author: Quentin LLOVERAS
Version: 0.1.5
Author URI: https://github.com/NeoNeTech
*/
define("ACIFOLDER", plugin_dir_url( __FILE__ ));
define("ACIPATH", plugin_dir_path( __FILE__ ));

$url = ACIFOLDER.'settings.json';
$data = file_get_contents($url);

$settings = json_decode($data);

add_action('admin_menu', 'aci_setup_menu');

function aci_setup_menu(){
  $icon = 'dashicons-pressthis';
  add_menu_page('Admin Change Image', 'ACI Settings', 'manage_options', 'aci', 'aci_settings', $icon);
}


function aci_settings(){
  global $settings ?>
  <link href="<?php echo ACIFOLDER ?>/aci-style.css" rel="stylesheet">

  <h1>Admin Change Image Settings</h1>
  <p>Bienvenue sur cette page de réglage qui va vous permettre de modifier de multiple élements CSS de la page login facilement.</p>
  <h2>Logo :</h2>
  <form method="POST" action=""/>
  <label for="url-logo">URL du logo :</label>
  <input type="text" name="url-logo" class="inputText" value="<?php echo $settings->logourl; ?>"/>
  <br />
  <label for="size-logo">Taille du logo :</label>
  <input type="number" name="size-logo" value="<?php echo $settings->logosize; ?>"/>

  <h2>Arrière plan :</h2>
  <label for="url-image">URL de l'arrière plan :</label>
  <input type="text" name="url-image" class="inputText" value="<?php echo $settings->imageurl; ?>"/>
  <br />
  <label for="size-image">Taille de l'arrière plan :</label>
  <select name="size-image" size="1">
    <option selected><?php echo $settings->imagesize; ?></option>
    <option>auto</option>
    <option>contain</option>
    <option>cover</option>
    <option>inerit</option>
    <option>initial</option>
    <option>unset</option>
  </select>
  <br />
  <h2>Login Box :</h2>
  <label for="url-logo">Radius :</label>
  <input type="number" name="radius-box" value="<?php echo $settings->radiusbox; ?>"/>
  <br/>
  <br/>
  <input type="submit" class="button button-primary button-large" value="Mettre à jour"/>
</form>

<footer class="aci_footer">
  <hr>
  <span>Plugin par Quentin LLOVERAS pour Nereus Water</span>
  <hr>
</footer>

<?php }

if(isset($_POST['url-logo']) || isset($_POST['size-logo']) || isset($_POST['url-image']) || isset($_POST['radius-box']) || isset($_POST['size-image'])){
  $settings = array("logourl" => htmlentities($_POST['url-logo']),"logosize" => htmlentities($_POST['size-logo']), "imageurl" => htmlentities($_POST['url-image']), "imagesize" => htmlentities($_POST['size-image']), "radiusbox" => htmlentities($_POST['radius-box']));
  echo $settings;
  $data = json_encode($settings);

  file_put_contents(ACIPATH.'settings.json', $data);
  header("Refresh:0");

}

function aci_login_style() {
  global $settings ?>
  <style type="text/css">
  #login h1 a, .login h1 a {
    background-image: url('<?php echo $settings->logourl; ?>');
    transform: scale(<?php echo $settings->logosize; ?>);
  }

  body.login {
    background-image: url('<?php echo $settings->imageurl; ?>');
    background-size: <?php echo $settings->imagesize; ?>; /* auto, contain, cover, inerit, initial, unset */
  }

  .login form {
    border-radius: <?php echo $settings->radiusbox; ?>px;
  }

  .login #backtoblog a, .login #nav a {
    color: white !important;
  }
  </style>
<?php }

add_action( 'login_enqueue_scripts', 'aci_login_style' );

function aci_admin_notice__success() {
  ?>
  <div class="notice notice-success is-dismissible">
    <p><?php _e( 'Mis à jour ! Tout les élements ont étais mis à jour !', 'Tout les élements ont étais mis à jour !' ); ?></p>
  </div>
  <?php
}
