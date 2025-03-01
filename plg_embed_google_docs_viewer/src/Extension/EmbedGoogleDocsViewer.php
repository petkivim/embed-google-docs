<?php
namespace Joomla\Plugin\Content\EmbedGoogleDocsViewer\Extension;

/**
 * @copyright   Copyright (C) 2012-2025 Petteri Kivimäki. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 * @author      Petteri Kivimäki
 */
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Event\Result\ResultAwareInterface;
use Joomla\CMS\Uri\Uri;

class EmbedGoogleDocsViewer extends CMSPlugin implements SubscriberInterface {

    public static function getSubscribedEvents(): array
    {
        return [
                'onContentPrepare' => 'onContentPrepare',   
                ];
    }

    function onContentPrepare(Event $event) {
        if (!$this->getApplication()->isClient('site')) {
            return;
        }

        // Get arguments - Joomla 4 and Joomla 5 are supported
        [$context, $article, $params, $page] = array_values($event->getArguments());
        if ($context !== "com_content.article" && $context !== "com_content.featured") return;

        $output = $article->text;
        $regex = "#{google_docs}(.*?){/google_docs}#s";
        $found = preg_match_all($regex, $output, $matches);

        // Set variables
        $pattern_google_docs = '/^http(s|):\/\/(docs|drive)\.google\.com/i';
        $pattern_url = '/^http(s|):\/\//i';

        // Load plugin params info
        $base_url = $this->params->def('base_url', Uri::base());
        $count = 0;

        if ($found) {
            foreach ($matches[0] as $value) {
                $add_link = $this->params->def('add_link', 1);
                $link_position = $this->params->def('link_position', 'bottom');
                $link_label = $this->params->def('link_label', 'View in full screen');
                $language = $this->params->def('language', '-');
                $height = $this->params->def('height', 300);
                $width = $this->params->def('width', 400);
                $border = $this->params->def('border', 0);
                $border_style = $this->params->def('border_style', 'solid');
                $border_color = $this->params->def('border_color', '#000000');
                $mode = $this->params->def('google_docs_mode', 0);
                $https = $this->params->def('https', 1);
                $protocol = "";
                $google_viewer_url = "docs.google.com/viewer?url=";

                $path = $value;
                $path = str_replace('{google_docs}', '', $path);
                $path = str_replace('{/google_docs}', '', $path);
                $doc_path = $path;
                $doc_path_link = $path;
                $find = '|';

                if (strstr($path, $find)) {
                    $arr = explode('|', $path);
                    $doc_path = $arr[0];

                    foreach ($arr as $phrase) {

                        if (strstr(strtolower($phrase), 'height:')) {
                            $tpm1 = explode(':', $phrase);
                            $height = trim($tpm1[1], '"');
                        }

                        if (strstr(strtolower($phrase), 'width:')) {
                            $tpm1 = explode(':', $phrase);
                            $width = trim($tpm1[1], '"');
                        }

                        if (strstr(strtolower($phrase), 'border:')) {
                            $tpm1 = explode(':', $phrase);
                            $border = trim($tpm1[1], '"');
                        }

                        if (strstr(strtolower($phrase), 'border_style:')) {
                            $tpm1 = explode(':', $phrase);
                            $border_style = trim($tpm1[1], '"');
                            $border_style = ( preg_match('/^(none|hidden|dotted|dashed|solid|double)$/i', $border_style) ? $border_style : 'solid' );
                        }

                        if (strstr(strtolower($phrase), 'border_color:')) {
                            $tpm1 = explode(':', $phrase);
                            $border_color = trim($tpm1[1], '"');
                        }

                        if (strstr(strtolower($phrase), 'lang:')) {
                            $tpm1 = explode(':', $phrase);
                            $language = trim($tpm1[1], '"');
                        }

                        if (strstr(strtolower($phrase), 'link:')) {
                            $tpm1 = explode(':', $phrase);
                            $tmp1 = trim($tpm1[1], '"');
                            if (strcmp(strtolower($tmp1), 'yes') == 0) {
                                $add_link = 0;
                            } else {
                                $add_link = 1;
                            }
                        }

                        if (strstr(strtolower($phrase), 'link_position:')) {
                            $tpm1 = explode(':', $phrase);
                            $tmp1 = trim($tpm1[1], '"');
                            if (strcmp(strtolower($tmp1), 'top') == 0) {
                                $link_position = "top";
                            } else {
                                $link_position = "bottom";
                            }
                        }

                        if (strstr(strtolower($phrase), 'link_label:')) {
                            $tpm1 = explode(':', $phrase);
                            $link_label = trim($tpm1[1], '"');
                        }

                        if (strstr(strtolower($phrase), 'mode:')) {
                            $tpm1 = explode(':', $phrase);
                            $tmp1 = trim($tpm1[1], '"');
                            if (strcmp(strtolower($tmp1), 'edit') == 0) {
                                $mode = 1;
                            } else if (strcmp(strtolower($tmp1), 'preview') == 0) {
                                $mode = 2;
                            } else if (strcmp(strtolower($tmp1), 'default') == 0) {
                                $mode = 0;
                            }
                        }

                        if (strstr(strtolower($phrase), 'https:')) {
                            $tpm1 = explode(':', $phrase);
                            $tmp1 = trim($tpm1[1], '"');
                            if (strcmp(strtolower($tmp1), 'yes') == 0) {
                                $https = 0;
                            } else {
                                $https = 1;
                            }
                        }
                    }
                }

                $protocol = ($https == 0) ? "https://" : "http://";
                $google_viewer_url = "$protocol$google_viewer_url";

                if (!preg_match($pattern_url, $doc_path)) {
                    $doc_path = "$base_url$doc_path";
                }

                $doc_path_link = $doc_path;

                if (strcmp($language, 'system') == 0) {
                    $lng = JFactory::getLanguage();
                    $langtag = $lng->getTag();
                    $langprfx = explode('-', $langtag);
                    $language = "&hl=" . $langprfx[0];
                } else if (strcmp($language, '-') != 0) {
                    $language = "&hl=$language";
                } else {
                    $language = "";
                }

                if (preg_match('/{(.*?)}/', $link_label, $mtcs)) {
                    $link_label = JText::_($mtcs[1]);
                }

                $border_color = (preg_match('/^#[a-f0-9]{6}$/i', $border_color) ? $border_color : '#000000');

                $replacement[$count] = "\n<iframe width='$width' height='$height' style='border: " . $border . "px $border_style $border_color' ";
                if (preg_match($pattern_google_docs, $doc_path)) {
                    $is_img = 0;
                    if (preg_match('/\/presentation\//i', $doc_path)) {
                        $doc_path = preg_replace('/(\/edit|\/preview).*$/', '', $doc_path);
                        $doc_path = preg_replace('/\/$/', '', $doc_path);
                        if ($mode == 1) {
                            $doc_path = str_replace('pub?id=', 'd/', $doc_path);
                            $doc_path = preg_replace('/&.*$/', '', $doc_path);
                            $doc_path .= '/edit';
                            $doc_path_link = $doc_path;
                        } else if ($mode == 2) {
                            $doc_path = str_replace('pub?id=', 'd/', $doc_path);
                            $doc_path = preg_replace('/&.*$/', '', $doc_path);
                            $doc_path .= '/preview';
                            $doc_path_link = $doc_path;
                        } else {
                            $doc_path = str_replace('d/', 'pub?id=', $doc_path);
                            $doc_path_link = $doc_path;
                            $doc_path = str_replace('/pub?', '/embed?', $doc_path);
                        }
                    } else if (preg_match('/\/document\//i', $doc_path)) {
                        $doc_path = preg_replace('/(\/edit|\/preview).*$/', '', $doc_path);
                        $doc_path = preg_replace('/\/$/', '', $doc_path);
                        if ($mode == 1) {
                            $doc_path = str_replace('pub?id=', 'd/', $doc_path);
                            $doc_path .= '/edit';
                            $doc_path_link = $doc_path;
                        } else if ($mode == 2) {
                            $doc_path = str_replace('pub?id=', 'd/', $doc_path);
                            $doc_path .= '/preview';
                            $doc_path_link = $doc_path;
                        } else {
                            if (preg_match('/\/pub$/i', $doc_path)) {
                                $doc_path_link = $doc_path;
                            } else {
                                $doc_path = str_replace('d/', 'pub?id=', $doc_path);
                                $doc_path_link = $doc_path;
                                $doc_path .= '&amp;embedded=true';
                            }
                        }
                    } else if (preg_match('/\/file\/d\//i', $doc_path)) {
                        $doc_path = preg_replace('/(\/edit|\/preview).*$/', '', $doc_path);
                        if ($mode == 1) {
                            $doc_path .= '/edit';
                        } else {
                            $doc_path .= '/preview';
                        }
                        $doc_path_link = $doc_path;
                    } else if (preg_match('/\/spreadsheet\//i', $doc_path)) {
                        if (preg_match('/formkey/i', $doc_path)) {
                            $doc_path = preg_replace('/#.*$/', '', $doc_path);
                            $doc_path_link = str_replace('embedded', 'view', $doc_path);
                            $doc_path = str_replace('view', 'embedded', $doc_path);
                        } else {
                            $doc_path = preg_replace('/#.*$/', '', $doc_path);
                            if ($mode == 1) {
                                $doc_path = str_replace('pub?', 'ccc?', $doc_path);
                                $doc_path = preg_replace('/&.*$/', '', $doc_path);
                                $doc_path_link = $doc_path;
                            } else {
                                $doc_path = str_replace('ccc?', 'pub?', $doc_path);
                                $doc_path_link = str_replace('widget=true', 'widget=false', $doc_path);
                                if (preg_match('/widget=true/i', $doc_path) == 0) {
                                    $doc_path .= '&amp;widget=true';
                                }
                            }
                        }
                    } else if (preg_match('/\/drawings\//i', $doc_path)) {
                        if ($mode == 1) {
                            $doc_path = str_replace('pub?id=', 'd/', $doc_path);
                            $doc_path = preg_replace('/&.*$/', '', $doc_path);
                            if (preg_match('/\/edit/i', $doc_path) == 0) {
                                $doc_path .= '/edit';
                            }
                            $doc_path_link = $doc_path;
                        } else {
                            $is_img = 1;
                            $doc_path = str_replace('d/', 'pub?id=', $doc_path);
                            $doc_path = preg_replace('/\/edit.*$/', "&amp;w=$width&amp;h=$height", $doc_path);
                            $doc_path_link = $doc_path;
                        }
                    }

                    if ($is_img == 0) {
                        $replacement[$count] .= "src='$doc_path'></iframe>\n";
                    } else {
                        $replacement[$count] = "\n<img width='$width' height='$height' style='border: " . $border . "px $border_style $border_color' src='$doc_path' />\n";
                    }
                } else {
                    $doc_path_link = urlencode($doc_path_link) . $language;
                    $replacement[$count] .= "src='$google_viewer_url" . urlencode($doc_path) . "&amp;embedded=true$language'></iframe>\n";
                }

                if ($add_link == 0) {
                    $html = $replacement[$count];
                    $link_html = "";
                    if (preg_match($pattern_google_docs, $doc_path)) {
                        $link_html = "<div><a href='$doc_path_link' target='new'>$link_label</a></div>\n";
                    } else {
                        $link_html = "<div><a href='$google_viewer_url$doc_path_link' target='new'>$link_label</a></div>\n";
                    }
                    $replacement[$count] = strcmp(strtolower($link_position), 'top') === 0 ? $link_html . $html : $html . $link_html;
                }
                $count++;
            }
            for ($i = 0; $i < count($replacement); $i++) {
                $output = preg_replace($regex, $replacement[$i], $output, 1);
            }
        }
        // Update the article text with the processed text
        $article->text = $output;
    }

}

?>
