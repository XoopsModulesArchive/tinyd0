<?php

if (!class_exists('TinyDTextSanitizer')) {
    require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';

    class TinyDTextSanitizer extends MyTextSanitizer
    {
        public $nbsp = 0;

        /*
        * Constructor of this class
        *
        * Gets allowed html tags from admin config settings
        * <br> should not be allowed since nl2br will be used
        * when storing data.
        *
        * @access	private
        *
        * @todo Sofar, this does nuttin' ;-)
        */

        public function __construct()
        {
        }

        /**
         * Access the only instance of this class
         *
         * @return    object
         *
         * @static
         * @staticvar   object
         */
        public static function &getInstance()
        {
            static $instance;

            if (!isset($instance)) {
                $instance = new self();
            }

            return $instance;
        }

        /**
         * Filters textarea form data in DB for display
         *
         * @param string $text
         * @param int    $html   allow html?
         * @param int    $smiley allow smileys?
         * @param int    $xcode  allow xoopscode?
         * @param int    $image  allow inline images?
         * @param int    $br     convert linebreaks?
         * @param mixed  $nbsp
         * @return  string
         */
        public function displayTarea($text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1, $nbsp = 0)
        {
            // save "javascript:"

            $text = preg_replace('/javascript:/si', 'jjaavvaassccrriipptt::', $text);

            $this->nbsp = $nbsp;

            $text = parent::displayTarea($text, $html, $smiley, $xcode, $image, $br);

            // restore "javascript:"

            $text = preg_replace('/jjaavvaassccrriipptt::/', 'javascript:', $text);

            return $this->tinyDCodeDecode($text, $nbsp);
            /*		if ($html != 1) {
                        // html not allowed
                        $text =& $this->htmlSpecialChars($text);
                    }
                    $text =& $this->makeClickable($text);
                    if ($smiley != 0) {
                        // process smiley
                        $text =& $this->smiley($text);
                    }
                    if ($xcode != 0) {
                        // decode xcode
                        if ($image != 0) {
                            // image allowed
                            $text =& $this->xoopsCodeDecode($text);
                                } else {
                                    // image not allowed
                                    $text =& $this->xoopsCodeDecode($text, 0);
                        }
                    }
                    if ($br != 0) {
                        $text =& $this->nl2Br($text);
                    }
                    return $text; */
        }

        /**
         * Replace TinyDCodes with their equivalent HTML formatting
         *
         * @param string $text
         * @return  string
         **/
        public function tinyDCodeDecode($text)
        {
            $removal_tags = ['[summary]', '[/summary]', '[pagebreak]'];

            $text = str_replace($removal_tags, '', $text);

            $patterns = [];

            $replacements = [];

            $patterns[] = "/\[siteimg align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";

            $replacements[] = '<img src="' . XOOPS_URL . '/\\3" align="\\2" alt="">';

            $patterns[] = "/\[siteimg]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";

            $replacements[] = '<img src="' . XOOPS_URL . '/\\1" alt="">';

            return preg_replace($patterns, $replacements, $text);
        }

        /**
         * get inside of tags [summary] and [/summary]
         *
         * @param string $text
         * @return  string
         **/
        public function tinyExtractSummary($text)
        {
            $patterns[] = "/^(.*)\[summary\](.*)\[\/summary\](.*)$/sU";

            $replacements[] = '$2';

            return preg_replace($patterns, $replacements, $text);
        }

        /**
         * Convert linebreaks to <br> tags
         *
         * @param string $text
         *
         * @return    string
         */
        public function nl2Br($text)
        {
            $text = preg_replace("/(\015\012)|(\015)|(\012)/", '<br>', $text);

            if ($this->nbsp) {
                $patterns = ['  ', '\"'];

                $replaces = [' &nbsp;', '"'];

                $text = mb_substr(preg_replace('/\>.*\</esU', "str_replace(\$patterns,\$replaces,'\\0')", ">$text<"), 1, -1);
            }

            return $text;
        }

        /*
        *  for displaying data in html textbox forms
        *
        * @param	string  $text
        *
        * @return	string
        */

        public function htmlSpecialChars($text)
        {
            return htmlspecialchars($text, ENT_QUOTES);
            //return preg_replace("/&amp;/i", '&', htmlspecialchars($text, ENT_QUOTES));
            // return preg_replace(array("/&amp;/i", "/&nbsp;/i"), array('&', '&amp;nbsp;'), htmlspecialchars($text, ENT_QUOTES));
        }

        // The End of Class
    }
}
