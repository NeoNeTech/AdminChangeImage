<?php
/*
Plugin Name: Admin Change Image
Plugin URI: https://nereus-water.com
Description: Plugin réaliser pour NEREUS Water, afin de pouvoir changer le logo dans l'interface de connexion
Author: Quentin LLOVERAS
Version: 0.2.5
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
    <a href="#options" id="option-click" class="nav-tab"><?php _e( 'Options', 'textdomain' ); ?></a>
    <a href="#preview" id="preview-click" class="nav-tab"><?php _e( 'Preview', 'textdomain' ); ?></a>
    <a href="#informations" id="info-click" class="nav-tab"><?php _e( 'À propos', 'textdomain' ); ?></a>
  </h2>

  <div id="options" class="tabs container">
  <form method="POST" action=""/>
  <h2>Logo :</h2>
  <label for="url-lien">Souhaitez-vous pointez vers votre page d'accueil ?</label>
  <input type="radio" name="url-lien" value="Check" <?php if($settings->lienurl == "Check"){ echo "checked=\"yes\"";} ?>/>Oui
  <input type="radio" name="url-lien" value="Uncheck" <?php if($settings->lienurl == "Uncheck"){ echo "checked=\"yes\"";} ?>/>Non
  <br />
  <label for="alt-logo">Alt du logo :</label>
  <input type="text" name="alt-logo" class="inputText" value="<?php echo $settings->logoalt; ?>" id="text-alt"/>
  <br />
  <label for="url-logo">URL du logo :</label>
  <input type="text" name="url-logo" class="inputText" value="<?php echo $settings->logourl; ?>" id="text-url"/>
  <br />
  <label for="size-logo">Taille du logo :</label>
  <input type="number" name="size-logo" class="inputNum" value="<?php echo $settings->logosize; ?>"/>
  <h2>Arrière plan :</h2>
  <label for="url-image">URL de l'arrière plan :</label>
  <input type="text" name="url-image" class="inputText" value="<?php echo $settings->imageurl; ?> " id="bg-url"/>
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
  <input type="text" vsalue="<?php echo $settings->colortext; ?>" name="color-text" class="my-color-field" data-default-color="<?php echo $settings->colortext; ?>" />  <br/>
  <?php submit_button(); ?>
</form>
<div class="previewBanner">
  <h3>Preview du logo :</h3>
  <img src="#" id="imgOutput" alt="Merci de rentrer une URL valide" height="250px"/>
  <h3>Preview de l'arrière plan :</h3>
  <img src="#" id="bgOutput" alt="Merci de rentrer une URL valide" height="250px"/>
</div>
</div>

<div id="preview">
  <h2>Preview de la page login :</h2>
  <div class="previewContainer">
    <img src="<?php echo $settings->logourl; ?>" alt="<?php echo $settings->logoalt; ?>" title="<?php echo $settings->logoalt; ?>" class="logo"/>
    <div class="form">
    <form name="loginform" id="loginform" action="#" method="post">
	<p>
		<label for="user_login" style="margin-left: 30px;">Identifiant ou adresse e-mail<br>
		<input type="text" name="log" id="user_login" class="input" value="" size="20" autocapitalize="off" style="margin-left: 30px;width:80%;"></label>
	</p>
	<p>
		<label for="user_pass" style="margin-left: 30px;">Mot de passe<br>
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" style="margin-left: 30px;width:80%;"></label>
	</p>
  <div style="display:flex;align-items:center;margin-left: 35px;">
			<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Se souvenir de moi</label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Se connecter" style="margin-left: 35%;">
	</p>
</div>
	</form>
</div>
  <style>
    .logo {
      height:75px;
      margin: 5% auto 5% 43%;
      text-align: center;
      position: absolute;
      transform: scale(<?php echo $settings->logosize; ?>);
    }
    #user_login, #user_pass {
      font-size: 24px;
      width: 100%;
      padding: 3px;
      margin: 2px 6px 16px 0;
      background: #fbfbfb;
    }

    #loginform {
      height: 285px;
      width: 350px;
      font-weight: 400;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 1px 3px rgba(0,0,0,.13);
      margin-top: 50vh; /* poussé de la moitié de hauteur de viewport */
      transform: translateY(-50%); /* tiré de la moitié de sa propre hauteur */
      border-radius: <?php echo $settings->radiusbox; ?>px;
      padding-top: 15px;
    }

    .form {
      display: flex;
      justify-content: center;
    }
    .previewContainer {
      width: 90%;
      height: 30%;
      background-image: url('<?php echo $settings->imageurl; ?>');
      background-size: <?php echo $settings->imagesize; ?>;
      <?php if($settings->effetvignettage == "Active"){ echo "box-shadow: inset 0 0 100px black;";} ?>
    }
  </style>
  <i style="color:white;margin:3px;">Ceci n'est qu'une représentation approximative de l'écran de login.</i>
</div>
</div>

<div id="informations" class="tabs">
  <div class="version"><span>V <?php echo ACIVERSION; ?></span></div>
  <p class="infos">Admin Change Image à étais conçu dans le cadre d'un stage pour l'entreprise <a href="https://nereus-water.com" target="_blank">Nereus Water</a></p>
  <h2>Changelog :</h2>
  <h3>V 0.2.5 : Preview Mode</h3>
    <ul>
      <li>Prévisualisation du logo</li>
      <li>Prévisualisation de l'arrière plan</li>
      <li>Ajout de l'onglet Preview qui permet d'avoir un aperçu de la page de login sans ce déconnecté</li>
    </ul>
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
