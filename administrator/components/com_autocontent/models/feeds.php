<?php

/**
 * Zt Autocontent
 * @package Joomla.Component
 * @subpackage com_autocontent
 * @version 0.5.0
 *
 * @copyright   Copyright (c) 2013 APL Solutions (http://apl.vn)
 *
 */
defined('_JEXEC') or die;

/**
 * Class exists checking
 */
if (!class_exists('AutoContentModelFeeds')) {
    jimport('joomla.application.component.modellist');
    jimport('joomla.filesystem.folder');
    jimport('joomla.filesystem.file');

    /**
     * FeedList Model
     */
    class AutoContentModelFeeds extends JModelList {

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return	string	An SQL query
         */
        protected function populateState($ordering = null, $direction = null) {
            // Initialise variables.
            $app = JFactory::getApplication('administrator');

            // Load the filter state.
            $type = $this->getUserStateFromRequest($this->context . '.filter.feed_type', 'filter_feed_type');
            $this->setState('filter.feed_type', $type);

            // Load the filter search.
            $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
            $this->setState('filter.search', $search);

            // List state information.
            parent::populateState('id', 'ASC');
        }

        protected function getListQuery() {
            // Create a new query object.		
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            // Select some fields
            $query->select('*');
            // From the hello table
            $query->from('#__autocontent_feed');

            $type = $this->getState('filter.feed_type');
            if ($type != "*" && $type != NULL) {
                $query->where('feed_type = ' . $db->Quote($type));
            }

            $type = $this->getState('filter.search');
            if ($this->getState('filter.search') !== '') {
                $token = $db->Quote('%' . $db->escape($this->getState('filter.search')) . '%');

                // Compile the different search clauses.
                $searches = array();
                $searches[] = 'feed_name LIKE ' . $token;
                $searches[] = 'feed_url LIKE ' . $token;

                // Add the clauses to the query.
                $query->where('(' . implode(' OR ', $searches) . ')');
            }

            $query->where('type = ' . $db->Quote('feed'));

            return $query;
        }

        public function getCategoryName($type = "k2", $cid = 0, $kid = 0) {
            $db = JFactory::getDBO();

            if ($type == 'content') {
                $query = "SELECT title FROM #__categories WHERE extension='com_content' AND id = " . $cid;
            } else {
                $query = "SELECT name FROM #__k2_categories WHERE id = " . $kid;
            }

            $db->setQuery($query);
            $name = $db->loadResult();

            return $name;
        }

        function getFeed($id) {
            $db = JFactory::getDBO();
            $query = "SELECT *, get_class as getclass FROM #__autocontent_feed WHERE id = " . $id;
            $db->setQuery($query);
            $row = $db->loadObject();

            return $row;
        }

        function delete($cid) {
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);

            $query->delete('#__autocontent_feed');
            $query->where('id IN (' . implode(", ", $cid) . ')');

            $db->setQuery((string) $query);
            $this->setError((string) $query);
            $db->query();

            // Check for a database error.
            if ($db->getErrorNum()) {
                $this->setError($db->getErrorMsg());
                return false;
            }

            return true;
        }

        function publish($cid, $value) {
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);

            $query->update('#__autocontent_feed');
            $query->set('published = ' . $value);
            $query->where('id IN (' . implode(", ", $cid) . ')');

            $db->setQuery((string) $query);
            $this->setError((string) $query);
            $db->query();

            // Check for a database error.
            if ($db->getErrorNum()) {
                $this->setError($db->getErrorMsg());
                return false;
            }

            return true;
        }

        function load($_feed) {
            $url = str_replace(' ', '+', $_feed->feed_url);
            $num = $_feed->get_articles;

            $feed = new SimplePie();
            $feed->enable_order_by_date(false);
            $feed->set_feed_url($url);
            $feed->set_item_limit($num);
            $feed->set_stupidly_fast(true);
            $feed->enable_cache(false);
            $feed->init();
            $feed->handle_content_type();

            return $feed;
        }

        function k2_is_duplicate($title) {
            $db = JFactory::getDBO();
            $query = "SELECT COUNT(*) FROM #__k2_items WHERE title = " . $db->Quote($title) . "";
            $db->setQuery($query);
            $count = $db->loadResult();

            return ($count) ? true : false;
        }

        function content_is_duplicate($title) {
            $db = JFactory::getDBO();
            $query = "SELECT COUNT(*) FROM #__content WHERE title = " . $db->Quote($title) . "";
            $db->setQuery($query);
            $count = $db->loadResult();

            return ($count) ? true : false;
        }

        function get_file($url) {
            if (ini_get('allow_url_fopen') != 1) {
                @ini_set('allow_url_fopen', '1');
            }

            if (ini_get('allow_url_fopen') != 1) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //Set curl to return the data instead of printing it to the browser.
                curl_setopt($ch, CURLOPT_URL, $url);
                $data = curl_exec($ch);
                curl_close($ch);
                return $data;
            } else {
                return @file_get_contents($url);
            }

            return false;
        }

        function convert_to_utf8($html, $header = null) {
            $accept = array(
                'type' => array('application/rss+xml', 'application/xml', 'application/rdf+xml', 'text/xml', 'text/html'),
                'charset' => array_diff(mb_list_encodings(), array('pass', 'auto', 'wchar', 'byte2be', 'byte2le', 'byte4be', 'byte4le', 'BASE64', 'UUENCODE', 'HTML-ENTITIES', 'Quoted-Printable', '7bit', '8bit'))
            );

            $encoding = null;
            if ($html || $header) {
                if (is_array($header))
                    $header = implode("\n", $header);

                if (!$header || !preg_match_all('/^Content-Type:\s+([^;]+)(?:;\s*charset=([^;"\'\n]*))?/im', $header, $match, PREG_SET_ORDER)) {
                    // error parsing the response
                } else {
                    $match = end($match); // get last matched element (in case of redirects)
                    if (!in_array(strtolower($match[1]), $accept['type'])) {
                        // type not accepted
                        // TODO: avoid conversion
                    }
                    if (isset($match[2]))
                        $encoding = trim($match[2], '"\'');
                }
                if (!$encoding) {
                    if (preg_match('/^<\?xml\s+version=(?:"[^"]*"|\'[^\']*\')\s+encoding=("[^"]*"|\'[^\']*\')/s', $html, $match)) {
                        $encoding = trim($match[1], '"\'');
                    } elseif (preg_match('/<meta\s+http-equiv=["\']Content-Type["\'] content=["\'][^;]+;\s*charset=([^;"\'>]+)/i', $html, $match)) {
                        if (isset($match[1]))
                            $encoding = trim($match[1]);
                    }
                }

                if (!$encoding) {
                    $encoding = 'utf-8';
                } else {
                    if (!in_array($encoding, array_map('strtolower', $accept['charset']))) {
                        // encoding not accepted
                        // TODO: avoid conversion
                    }
                    if (strtolower($encoding) != 'utf-8') {
                        if (strtolower($encoding) == 'iso-8859-1') {
                            // replace MS Word smart qutoes
                            $trans = array();
                            $trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark
                            $trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
                            $trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark
                            $trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis
                            $trans[chr(134)] = '&dagger;';    // Dagger
                            $trans[chr(135)] = '&Dagger;';    // Double Dagger
                            $trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
                            $trans[chr(137)] = '&permil;';    // Per Mille Sign
                            $trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron
                            $trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark
                            $trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE
                            $trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark
                            $trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark
                            $trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark
                            $trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark
                            $trans[chr(149)] = '&bull;';    // Bullet
                            $trans[chr(150)] = '&ndash;';    // En Dash
                            $trans[chr(151)] = '&mdash;';    // Em Dash
                            $trans[chr(152)] = '&tilde;';    // Small Tilde
                            $trans[chr(153)] = '&trade;';    // Trade Mark Sign
                            $trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron
                            $trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark
                            $trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE
                            $trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
                            $html = strtr($html, $trans);
                        }
                        if (!class_exists('SimplePie_Misc'))
                            require_once(RPURINC . 'simplepie.class.php');

                        $html = SimplePie_Misc::change_encoding($html, $encoding, 'utf-8');
                    }
                }
            }
            return $html;
        }

        function full_feed($permalink, $regArray) {
            if ($permalink && $html = $this->get_file($permalink)) {
                $html = $this->convert_to_utf8($html);
                $content = grabArticleHtml($html, $regArray);
            } else {
                return false;
            }

            if (false !== stripos($content, 'readability was unable to parse this page for content'))
                return false;
            if (false !== stripos($content, 'return go_back();'))
                return false;

            return $content;
        }

        function title_fix($title) {
            if ($title && strpos($title, ' - ')) {
                $backup = $title;
                $backup = preg_replace('/([-])/', '$1[D]', $backup);
                $backup = explode('[D]', $backup);

                if (strlen($backup[0]) > 10 || count($backup) >= 2)
                    unset($backup[count($backup) - 1]);
                else
                    return $title;

                $title = trim(implode('', $backup), ' - ');
            }
            return $title;
        }

        function content_fix($text, $feed) {
            $is_remove = $feed->remove_tag;
            $allow_tags = $feed->allow_tags;
            $allow_tags = str_replace("/", "", $allow_tags);
            $allow_tags = str_replace(" ", "", $allow_tags);

            if ($is_remove) {
                $text = strip_tags($text, $allow_tags);
            }

            if ($feed->ignore_class == '' && $feed->ignore_id == '') {
                return $text;
            }

            $document = new DOMDocument();
            $text = mb_convert_encoding($text, 'HTML-ENTITIES', "UTF-8");
            @$document->loadHTML($text);

            $allParagraphs = $document->getElementsByTagName('*');
            $articleContent = $document->createElement('div');

            foreach ($allParagraphs as $node) {
                if ($node->tagName == 'html' || $node->tagName == 'body') {
                    continue;
                }

                $pid = $node->parentNode->getAttribute('id');
                $pclass = $node->parentNode->hasAttribute('class');
                $class = $node->hasAttribute('class');
                $id = $node->hasAttribute('id');

                //Parent node			
                if ($pclass && $node->parentNode->getAttribute('class') != '' && $feed->ignore_class != '') {
                    if (preg_match('/(' . $feed->ignore_class . ')/', $node->parentNode->getAttribute('class'))) {
                        $node->parentNode->parentNode->removeChild($node->parentNode);
                    }
                }
                if ($pid && $node->parentNode->getAttribute('id') != '' && $feed->ignore_id != '') {
                    if (preg_match('/(' . $feed->ignore_id . ')/', $node->parentNode->getAttribute('id'))) {
                        $node->parentNode->parentNode->removeChild($node->parentNode);
                    }
                }

                //Child node
                if ($class && $node->getAttribute('class') != '' && $feed->ignore_class != '') {
                    if (preg_match('/(' . $feed->ignore_class . ')/', $node->getAttribute('class'))) {
                        $node->parentNode->removeChild($node);
                    }
                }
                if ($id && $node->getAttribute('id') != '' && $feed->ignore_id != '') {
                    if (preg_match('/(' . $feed->ignore_id . ')/', $node->getAttribute('id'))) {
                        $node->parentNode->removeChild($node);
                    }
                }
            }

            foreach ($allParagraphs as $node) {
                $articleContent->appendChild($node);
            }

            $text = $articleContent->ownerDocument->saveXML($articleContent);
            $text = str_replace(array('<html>', '<body>', '</body>', '</html>'), '', $text);

            return $text;
        }

        function parse_images($content, $link, $feed) {
            preg_match_all('/<img(.+?)src=\"(.+?)\"(.*?)>/', $content, $images);
            $urls = $images[2];

            if (count($urls)) {
                foreach ($urls as $pos => $url) {
                    $oldurl = $url;
                    $meta = parse_url($url);

                    if (!isset($meta['host'])) {
                        $meta = parse_url($link);
                        $url = str_replace("../", "", $url);
                        $url = $meta['scheme'] . '://' . $meta['host'] . '/' . $url;
                    }

                    $newurl = $this->cache_image($url, $feed);
                    if ($newurl)
                        $content = str_replace($oldurl, $newurl, $content);
                    else
                        $content = str_replace($images[0][$pos], '', $content);
                }
            }

            return $content;
        }

        function cache_image($url, $feed) {
            if (strpos($url, "icon_") !== FALSE)
                return false;

            $contents = $this->get_file($url);

            if (!$contents)
                return false;

            $basename = basename($url);
            $paresed_url = parse_url($basename);
            $filename = $paresed_url['path'];
            $cachepath = date("Y-m-d");
            $root = JURI::root();
            $real_cachepath = $feed->image_path . DS . $cachepath;

            if (!JFolder::exists(JPATH_ROOT . DS . $real_cachepath)) {
                JFolder::create(JPATH_ROOT . DS . $real_cachepath);
            }

            if (!JFolder::exists(JPATH_ROOT . DS . $real_cachepath)) {
                $real_cachepath = "images" . DS . "com_autocontent" . DS . $cachepath;
                JFolder::create(JPATH_ROOT . DS . $real_cachepath);
            }

            if (is_writable(JPATH_ROOT . DS . $real_cachepath)) {
                if ($contents) {
                    if (!JFile::exists(JPATH_ROOT . DS . $real_cachepath . DS . $filename))
                        JFile::write(JPATH_ROOT . DS . $real_cachepath . DS . $filename, $contents);

                    return str_replace(DS, "/", $real_cachepath . DS . rawurlencode($filename));
                }
            }

            return false;
        }

        function replaceText($text, $feed) {
            $strings = $feed->replace_texts;

            if ($strings != NULL && $strings != "") {
                $rows = explode(", ", $strings);
                if (count($rows))
                    for ($i = 0; $i < count($rows); $i++) {
                        list($find, $rep) = explode("|", $rows[$i]);
                        $text = str_replace($find, $rep, $text);
                    }
            }

            return $text;
        }

        function processData($data, $feed) {
            $max_items = $feed->get_articles;
            $count = 0;

            $regArray = array();
            if ($feed->getclass != "" || $feed->ignore_class != "" || $feed->get_id != "" || $feed->ignore_id != "") {
                $regArray['getclass'] = $feed->getclass;
                $regArray['ignoreclass'] = $feed->ignore_class;
                $regArray['getid'] = $feed->get_id;
                $regArray['ignoreid'] = $feed->ignore_id;
            }

            //Log
            $text = "<b>-----------Processing feed: " . $feed->feed_name . " (" . $feed->feed_url . ")" . "------------</b>";
            $this->writeLog($text);

            foreach ($data->get_items() as $item) {
                $title = $item->get_title();
                $link = $item->get_permalink();
                $title = $this->title_fix($title);

                if (false !== strpos($link, 'news.google.com')) {
                    $link = urldecode(substr($link, strpos($link, 'url=') + 4));
                } elseif (false !== strpos($link, '/**')) {
                    $link = urldecode(substr($link, strpos($link, '/**') + 3));
                }

                //Check duplicate
                if ($feed->feed_type == 'k2')
                    if ($this->k2_is_duplicate($title))
                        continue;

                if ($feed->feed_type == 'content')
                    if ($this->content_is_duplicate($title))
                        continue;

                //Process item			
                $content = $this->full_feed($link, $regArray);

                if (!$content) {
                    //Log
                    $text = "<b>-----------Load content fails !------------</b>";
                    $this->writeLog($text);

                    return false;
                }

                $introtext = $this->content_fix($item->get_description(), $feed);
                $content = $this->content_fix($content, $feed);

                if (empty($title) || empty($content)) {
                    //Log
                    $text = "<b>-----------Load content fails !------------</b>";
                    $this->writeLog($text);

                    return false;
                }

                $introtext = $this->parse_images($introtext, $item->get_base(), $feed);
                $content = $this->parse_images($content, $item->get_base(), $feed);

                //Replace text
                $introtext = $this->replaceText($introtext, $feed);
                $content = $this->replaceText($content, $feed);

                //Insert to K2 System            
                if ($feed->feed_type == 'k2') {
                    if (AutoContentHelper::isK2Enabled()) {
                        $this->processK2Data($title, $introtext, $content, $feed);
                    }
                }

                //Insert to Content System
                if ($feed->feed_type == 'content')
                    $this->processContentData($title, $introtext, $content, $feed);

                $count++;
                if ($count == $max_items) {
                    break;
                }
            }
        }

        function creatAlias($title, $feed) {
            $title = strip_tags($title);

            jimport('joomla.filter.output');
            mb_internal_encoding("UTF-8");
            mb_regex_encoding("UTF-8");

            $alias = trim(mb_strtolower($title));
            $alias = str_replace('-', ' ', $alias);
            $alias = str_replace('/', '-', $alias);
            $alias = mb_ereg_replace('[[:space:]]+', ' ', $alias);
            $alias = trim(str_replace(' ', '-', $alias));
            $alias = str_replace('.', '', $alias);
            $alias = str_replace('"', '', $alias);
            $alias = str_replace("'", '', $alias);

            $stripthese = ',|~|!|@|%|^|(|)|<|>|:|;|{|}|[|]|&|`|â€ž|â€¹|â€™|â€˜|â€œ|â€�|â€¢|â€º|Â«|Â´|Â»|Â°|«|»|…';

            $strips = explode('|', $stripthese);

            foreach ($strips as $strip) {
                $alias = str_replace($strip, '', $alias);
            }
            $feed->replace_chars .= ',á|a, à|a, ả|a, ã|a, ạ|a, â|a, ấ|a, ầ|a, ẩ|a, ẫ|a, ậ|a, ă|a, ắ|a, ằ|a, ẳ|a, ẵ|a, ặ|a, đ|d, é|e, è|e, ẻ|e, ẽ|e, ẹ|e, ê|e, ế|e, ề|e, ể|e, ễ|e, ệ|e, í|i, ì|i, ỉ|i, ĩ|i, ị|i, ó|o, ò|o, ỏ|o, õ|o, ọ|o, ô|o, ố|o, ồ|o, ổ|o, ỗ|o, ộ|o, ơ|o, ớ|o, ờ|o, ở|o, ỡ|o, ợ|o, ú|u, ù|u, ủ|u, ũ|u, ụ|u, ư|u, ứ|u, ừ|u, ử|u, ữ|u, ự|u, ý|y, ỳ|y, ỷ|y, ỹ|y, ỵ|y, Á|A, À|A, Ả|A, Ã|A, Ạ|A, Â|A, Ấ|A, Ầ|A, Ẩ|A, Ẫ|A, Ậ|A, Ă|A, Ắ|A, Ằ|A, Ẳ|A, Ẵ|A, Ặ|A, Đ|D, É|E, È|E, Ẻ|E, Ẽ|E, Ẹ|E, Ê|E, Ế|E, Ề|E, Ể|E, Ễ|E, Ệ|E, Í|I, Ì|I, Ỉ|I, Ĩ|I, Ị|I, Ó|O, Ò|O, Ỏ|O, Õ|O, Ọ|O, Ô|O, Ố|O, Ồ|O, Ổ|O, Ỗ|O, Ộ|O, Ơ|O, Ớ|O, Ờ|O, Ở|O, Ỡ|O, Ợ|O, Ú|U, Ù|U, Ủ|U, Ũ|U, Ụ|U, Ư|U, Ứ|U, Ừ|U, Ử|U, Ữ|U, Ự|U, Ý|Y, Ỳ|Y, Ỷ|Y, Ỹ|Y, Ỵ|Y';
            $SEFReplacements = array();
            $items = explode(',', $feed->replace_chars);
            foreach ($items as $item) {
                if (!empty($item)) {
                    @list($src, $dst) = explode('|', trim($item));
                    $SEFReplacements[trim($src)] = trim($dst);
                }
            }

            foreach ($SEFReplacements as $key => $value) {
                $alias = str_replace($key, $value, $alias);
            }

            $alias = trim($alias, '-.');

            if (JFactory::getConfig()->get('unicodeslugs') == 1) {
                $alias = JApplication::stringURLSafe($alias);
            }
            return $alias;
        }

        function processK2Data($title, $introtext, $content, $feed) {
            $db = JFactory::getDBO();
            $user = &JFactory::getUser();
            $post = array();

            JTable::addIncludePath(JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_k2' . DS . 'tables');
            $row = &JTable::getInstance('K2Item', 'Table');
            $datenow = &JFactory::getDate();

            //Handle data
            $alias = $this->creatAlias($title, $feed);
            $catid = $feed->k2_id;
            $published = $feed->status;
            $created_by = $feed->author_id;

            $post['id'] = NULL;
            $post['title'] = $title;
            $post['alias'] = $alias;
            $post['catid'] = $catid;
            $post['published'] = $published;
            $post['introtext'] = $introtext;
            $post['fulltext'] = $content;
            $post['created_by'] = ($created_by) ? $created_by : $user->get('id');
            $post['created'] = ($feed->creation_date != '0000-00-00 00:00:00') ? $feed->creation_date : $datenow->toSql();
            $post['publish_up'] = ($feed->start_publishing != '0000-00-00 00:00:00') ? $feed->start_publishing : $datenow->toSql();
            $post['language'] = "*";
            $post['featured'] = 0;

            //Log
            $text = "K2 System: <b>" . $title . "</b> added";
            $this->writeLog($text);

            if (!$row->bind($post)) {
                return false;
            }

            if (!$row->store()) {
                return false;
            }

            return true;
        }

        function processContentData($title, $introtext, $content, $feed) {
            $db = JFactory::getDBO();
            $user = JFactory::getUser();
            $post = array();

            $row = JTable::getInstance('Content', 'AutoContentTable');
            $datenow = &JFactory::getDate();

            //Handle data
            $alias = $this->creatAlias($title, $feed);
            $catid = $feed->content_id;
            $published = $feed->status;
            $created_by = $feed->author_id;

            $post['id'] = NULL;
            $post['title'] = $title;
            $post['alias'] = $alias;
            $post['catid'] = $catid;
            $post['state'] = $published;
            $post['introtext'] = $introtext;
            $post['fulltext'] = $content;
            $post['created_by'] = ($created_by) ? $created_by : $user->get('id');
            $post['language'] = "*";
            $post['featured'] = 0;
            $post['created'] = ($feed->creation_date != '0000-00-00 00:00:00') ? $feed->creation_date : $datenow->toSql();
            $post['publish_up'] = ($feed->start_publishing != '0000-00-00 00:00:00') ? $feed->start_publishing : $datenow->toSql();

            //Log
            $text = "Content System: <b>" . $title . "</b> added";
            $this->writeLog($text);

            if (!$row->bind($post)) {
                return false;
            }

            if (!$row->store()) {
                return false;
            }

            return true;
        }

        function writeLog($text) {
            $db = JFactory::getDBO();
            $user = JFactory::getUser();
            $post = array();

            $row = JTable::getInstance('Log', 'AutoContentTable');
            $post['id'] = NULL;
            $post['message'] = $text;
            $post['created_on'] = date("Y-m-d H:i:s");

            if (!$row->bind($post)) {
                return false;
            }

            if (!$row->store()) {
                return false;
            }

            return true;
        }

        function getAllFeeds() {
            $db = JFactory::getDBO();

            $query = $db->getQuery(true);
            // Select some fields
            $query->select('*');
            // From the feed table
            $query->from('#__autocontent_feed');
            //Where
            $query->where('published = 1');
            $query->where('type = "feed"');

            $db->setQuery((string) $query);
            $this->setError((string) $query);

            $rows = $db->loadObjectList();

            return $rows;
        }

    }

}
