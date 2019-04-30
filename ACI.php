<?php
/*
Plugin Name: Admin Change Image
Plugin URI: https://nereus-water.com
Description: Plugin réaliser pour NEREUS Water, afin de pouvoir changer le logo dans l'interface de connexion
Author: Quentin LLOVERAS
Version: 0.2.1
Author URI: https://github.com/NeoNeTech
*/
define("ACIFOLDER", plugin_dir_url( __FILE__ ));
define("ACIPATH", plugin_dir_path( __FILE__ ));

$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_version = $plugin_data['Version'];

define("ACIVERSION", $plugin_version);

$url = ACIFOLDER.'settings.json';
$data = file_get_contents($url);

$settings = json_decode($data);

add_action('admin_menu', 'aci_setup_menu');

function aci_setup_menu(){
  $icon = 'dashicons-pressthis';
  add_menu_page('Admin Change Image', 'ACI Settings', 'manage_options', 'aci', 'aci_settings', $icon, 50);
}

function aci_settings(){
  global $settings ?>
  <link href="<?php echo ACIFOLDER; ?>/aci-style.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
  <h1>Admin Change Image Settings</h1>
  <h2 class="nav-tab-wrapper">
        <a href="#" id="option-click" class="nav-tab"><?php _e( 'Options', 'textdomain' ); ?></a>
        <a href="#" id="info-click" class="nav-tab"><?php _e( 'À propos', 'textdomain' ); ?></a>
  </h2>

  <div id="options" class="tabs">
  <h2>Logo :</h2>
  <form method="POST" action=""/>
  <label for="url-lien">Souhaitez-vous pointez vers votre page d'accueil ?</label>
  <input type="radio" name="url-lien" value="Check" <?php if($settings->lienurl == "Check"){ echo "checked=\"yes\"";} ?>/>Oui
  <input type="radio" name="url-lien" value="Uncheck" <?php if($settings->lienurl == "Uncheck"){ echo "checked=\"yes\"";} ?>/>Non
  <br />
  <label for="alt-logo">Alt du logo :</label>
  <input type="text" name="alt-logo" class="inputText" value="<?php echo $settings->logoalt; ?>"/>
  <br />
  <label for="url-logo">URL du logo :</label>
  <input type="text" name="url-logo" class="inputText" value="<?php echo $settings->logourl; ?>"/>
  <br />
  <label for="size-logo">Taille du logo :</label>
  <input type="number" name="size-logo" class="inputNum" value="<?php echo $settings->logosize; ?>"/>
  <h2>Arrière plan :</h2>
  <label for="url-image">URL de l'arrière plan :</label>
  <input type="text" name="url-image" class="inputText" value="<?php echo $settings->imageurl; ?>"/>
  <br />
  <label for="size-image">Taille de l'arrière plan :</label>
  <select name="size-image" class="inputNum" size="1">
    <option selected><?php echo $settings->imagesize; ?></option>
    <option>auto</option>
    <option>contain</option>
    <option>cover</option>
    <option>inerit</option>
    <option>initial</option>
    <option>unset</option>
  </select>
  <br />
  <label for="url-image">Effet vignettage :</label>
  <input type="radio" name="effet-vignettage" value="Active" <?php if($settings->effetvignettage == "Active"){ echo "checked=\"yes\"";} ?>/>Activé
  <input type="radio" name="effet-vignettage" value="Desactive" <?php if($settings->effetvignettage == "Desactive"){ echo "checked=\"yes\"";} ?>/>Désactivé
  <br />
  <h2>Login Box :</h2>
  <label for="url-logo">Radius :</label>
  <input type="number" name="radius-box" class="inputNum" value="<?php echo $settings->radiusbox; ?>"/>
  <br/>
  <h2>Texte :</h2>
  <label for="color-text">Couleur :</label>
  <input type="text" value="<?php echo $settings->colortext; ?>" name="color-text" class="my-color-field" data-default-color="<?php echo $settings->colortext; ?>" />  <br/>
  <?php submit_button(); ?>
</form>
</div>

<div id="informations" class="tabs">
  <div class="version"><span>V <?php echo ACIVERSION; ?></span></div>
  <p class="infos">Admin Change Image à étais conçu dans le cadre d'un stage pour l'entreprise <a href="https://nereus-water.com" target="_blank">Nereus Water</a></p>
  <h2>Changelog :</h2>
    <h3>V 0.2.1 : Correction de bug</h3>
    <ul>
      <li>Correction de bug sur le système d'onglet</li>
    </ul>
    <h3>V 0.2.0 : Correction de bug & Implémentation d'options</h3>
    <ul>
      <li>Ajout d'un système d'onglet</li>
      <li>Possibilité de redirigé le logo sur la page d'accueil</li>
      <li>Possibilité d'ajouter un texte au survol du logo</li>
      <li>Ajout d'un effet vignettage</li>
      <li>Possibilité de modifier la couleur du texte</li>
    </ul>
    <h3>V 0.1.0 : Les bases sont posées</h3>
      <ul>
        <li>Possibilité de modifier le logo</li>
        <li>Possibilité de modifier la taille du logo</li>
        <li>Possibilité l'arrière plan</li>
        <li>Possibilité d'ajuster la taille de l'arrière plan</li>
        <li>Possibilité d'ajouter des coins arrondis à la login box</li>
      </ul>
</div>

  <hr>
  <footer class="aci_footer">
    <span>Plugin par <a href="https://paypal.me/quentinlloveras" target="_blank">Quentin LLOVERAS</a> pour <a href="https://nereus-water.com" target="_blank">Nereus Water</a></span>
    <span>Version <?php echo ACIVERSION ?></span>
  </footer>
  <hr>
<?php }

if(isset($_POST['url-logo']) || isset($_POST['url-image'])){
  $settings = array("lienurl" => htmlentities($_POST['url-lien']),
                    "logoalt" => htmlentities($_POST['alt-logo']),
                    "logourl" => htmlentities($_POST['url-logo']),
                    "logosize" => htmlentities($_POST['size-logo']),
                    "imageurl" => htmlentities($_POST['url-image']),
                    "imagesize" => htmlentities($_POST['size-image']),
                    "effetvignettage" => htmlentities($_POST['effet-vignettage']),
                    "radiusbox" => htmlentities($_POST['radius-box']),
                    "colortext" => htmlentities($_POST['color-text']));
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
    background-size: <?php echo $settings->imagesize; ?>;
    <?php if($settings->effetvignettage == "Active"){ echo "box-shadow: inset 0 0 100px black;";} ?>
  }

  .login form {
    border-radius: <?php echo $settings->radiusbox; ?>px;
  }

  .login #backtoblog a, .login #nav a {
    color: <?php echo $settings->colortext; ?> !important;
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

function aci_login_logo_url() {
return get_bloginfo( 'url' );
}

if($settings->lienurl == "Check"){
  add_filter( 'login_headerurl', 'aci_login_logo_url' );
}

function aci_login_logo_url_title() {
global $settings;
return $settings->logoalt;
}
add_filter( 'login_headertitle', 'aci_login_logo_url_title' );

add_action( 'admin_enqueue_scripts', 'aci_color_picker' );
function aci_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', ACIFOLDER.'app.js', array( 'wp-color-picker' ), false, true );
}
