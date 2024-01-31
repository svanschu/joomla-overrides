<?php
/**
 * Template override to create a link tree with a menu
 * 
 * @copyright   (C) 2024 Sven Schultschik. <https://www.schultschik.de>
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Filter\OutputFilter;

$attributes = [];

if ($item->anchor_title) {
    $attributes['title'] = $item->anchor_title;
}

if ($item->anchor_css) {
    $attributes['class'] = $item->anchor_css;
}

if ($item->anchor_rel) {
    $attributes['rel'] = $item->anchor_rel;
}

$linktype = '';

$iconClass = '';
if (str_contains($item->flink, 'x.com'))
    $iconClass .= ' fa-x-twitter';
elseif (str_contains($item->flink, 'mastodon'))
    $iconClass .= ' fa-mastodon';
elseif (str_contains($item->flink, 'linkedin.com'))
    $iconClass .= ' fa-linkedin-in';
elseif (str_contains($item->flink, 'xing.com'))
    $iconClass .= ' fa-xing';
elseif (str_contains($item->flink, 'github.com'))
    $iconClass .= ' fa-github';
elseif (str_contains($item->flink, 'facebook.com'))
    $iconClass .= ' fa-facebook-f';
elseif (str_contains($item->flink, 'instagram.com'))
    $iconClass .= ' fa-instagram';

if ($item->menu_icon) {
    // The link is an icon
    if ($itemParams->get('menu_text', 1)) {
        // If the link text is to be displayed, the icon is added with aria-hidden
        $linktype = '<span class="' . $item->menu_icon . '" aria-hidden="true"></span>' . $item->title;
    } else {
        // If the icon itself is the link, it needs a visually hidden text
        $linktype = '<span class="' . $item->menu_icon . '" aria-hidden="true"></span><span class="visually-hidden">' . $item->title . '</span>';
    }
} elseif (!empty($iconClass)) {
    $linktype = '<i class="fa-brands ' . $iconClass . '"></i>';
    if ($itemParams->get('menu_text', 1))
        $linktype .= ' ' . $item->title;
}

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

$link = HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);

echo '<button type="button" class="btn btn-light">' . $link . '</button>';
