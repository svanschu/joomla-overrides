<?php
/**
 * Template override to create a link tree with a menu
 * 
 * @copyright   (C) 2024 Sven Schultschik. <https://www.schultschik.de>
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Filter\OutputFilter;

$app      = Factory::getApplication();
$template = $app->getTemplate();

$attributes = [];

if ($item->anchor_title) {
    $attributes['title'] = $item->anchor_title;
}

$moduleclass_sfx = $params->get('moduleclass_sfx', '');
$btn_class     = 'btn-primary';
if (!empty($moduleclass_sfx))
    $btn_class = $moduleclass_sfx;

$attributes['class'] = 'btn ' . $btn_class . ' mb-3';
if ($item->anchor_css) {
    $attributes['class'] .= ' ' . $item->anchor_css;
}

if ($item->anchor_rel) {
    $attributes['rel'] = $item->anchor_rel;
}

$linktype = '<div class="container">'
    . '<div class="row align-items-center">'
    . '<div class="col col-4 col-md-1">';

if ($item->menu_image) {
    // The link is an image, maybe with an own class
    $image_attributes = [];

    $image_attributes['class'] = 'card-img-left ';
    if ($item->menu_image_css) {
        $image_attributes['class'] .= $item->menu_image_css;
    }

    $linktype .= HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);
} else {
    //$linktype .= '<img src="/templates/' . $template . '/html/mod_menu/blank.svg" alt="blank" />';
    $linktype .= '<img src="'. JPATH_THEMES . '/' . $template . '/html/mod_menu/blank.svg" alt="blank" />';
}

$titles = explode("___", $item->title);

$linktype .= '</div>'
    . '<div class="col col-8 col-md-11">'
    . $titles[0];
if (count($titles) >= 2) {
    $linktype .= '<br />'
        . '<small>' . $titles[1] . '</small>';
}
$linktype .= '</div>'
    . '</div>'
    . '</div>';

if ($item->browserNav == 1) {
    $attributes['target'] = '_blank';
    $attributes['rel']    = 'noopener noreferrer';

    if ($item->anchor_rel == 'nofollow') {
        $attributes['rel'] .= ' nofollow';
    }
} elseif ($item->browserNav == 2) {
    $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');

    $attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
