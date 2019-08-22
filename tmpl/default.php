<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addStylesheet(JURI::root(true) . '/modules/mod_username/assets/css/modUserName.css');

$head_html .= '<div class="header-username">';
$head_html .= '</div>';

$menu_html .= '<div class="menu header-username">';
$menu_html .= '<span class="userpic" style="background-color:'.$getColor.';">'.$modUserName->setUserInitials().'</span>';
$menu_html .= '<span class="username">'.$modUserName->getJoomlaUserName().'</span>';
$menu_html .= '<div class="proj"><span class="project-name">'.$modUserName->setProjectName().'</span></div>';
$menu_html .= '<div class="navbar-menu-divider paddingBottom--quarter"></div>';
$menu_html .= '</div>';
echo $head_html;

echo '
  <script>

    jQuery(".sm-menu").prepend(\''.$menu_html.'\');

  </script>';

$head_version .= '<span class="head-span-first version-numbers">'.$modUserName->showVersionNumber().'</span>';

echo '
  <script>

    jQuery(".version-number").append(\''.$head_version.'\');

  </script>';
?>