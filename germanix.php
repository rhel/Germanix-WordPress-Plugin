<?php
/*
Plugin Name: Germanix
Plugin URI:  http://toscho.de/
Description: Rüstet deutsche Übersetzungen im Backend nach.
Version:     0.1
Author:      Thomas Scholz
Author URI:  http://toscho.de
Created:     13.05.2010
*/

if ( is_admin() )
{
	add_filter('gettext',
		array ( 'Germanizer', 'gettext_filter'   ),      10, 1);
	add_filter('ngettext',
		array ( 'Germanizer', 'ngettext_filter'  ),      10, 3);
	add_filter('http_request_args',
		array ( 'Germanizer', 'no_upgrade_check' ),       5, 2);

	remove_filter('sanitize_title', 'sanitize_title_with_dashes');
	add_filter('sanitize_title',
		array ( 'Germanizer', 'sanitize_title_filter' ), 10, 1);
}

class Germanizer
{
	/**
	 * Adds missing translations in gettext.
	 *
	 * @param  string $str
	 * @return string
	 */
	static function gettext_filter($str)
	{
		return strtr($str, array (
			// Extend to fit your needs.
			'Dashboard'             => 'Übersicht',
			'Submitted on'          => 'Eingereicht am',
			'Biographische Angaben' => 'Beschreibung',
			'- Wähle -' 			=> 'Wähle',
			'Theme Files' 			=> 'Theme-Dateien',
			'Attribute' 			=> 'Eigenschaften',
			'Template' 				=> 'Vorlage',
			'neues Fenster oder neuen Tab.'
							=> 'neues Fenster oder neuer Tab.',
			'aktuelle Fenster oder aktueller Tab, ohne Frames.'
							=> 'aktuelles Fenster oder aktueller Tab, ohne Frames.',
		));
	}

	/**
	 * Adds missing translations in ngettext.
	 *
	 * @param  string $translation
	 * @param  string $single
	 * @param  string $plural
	 * @return string
	 */
	static function ngettext_filter($trans, $single, $plural)
	{
		return "Approved" == $plural ? "Genehmigte" : $trans;
	}

	/**
	 * Replaces German characters.
	 * Modified version of Heiko Rabe’s code.
	 *
	 * http://github.com/wordpress/wordpress/blob/master/wp-includes/formatting.php#L531
	 * is unfortunately completely inappropriate.
	 *
	 * @author Heiko Rabe http://code-styling.de
	 * @link   http://www.code-styling.de/?p=574
	 * @param  string $title
	 * @return string
	 */
	static function sanitize_title_filter($title)
	{
		$utf8 = array (
				'Ä' => 'Ae'
			,	'ä' => 'ae'
			,	'Æ' => 'Ae'
			,	'æ' => 'ae'
			,	'À' => 'A'
			,	'à' => 'a'
			,	'Á' => 'A'
			,	'á' => 'a'
			,	'Â' => 'A'
			,	'â' => 'a'
			,	'Ã' => 'A'
			,	'ã' => 'a'
			,	'Å' => 'A'
			,	'å' => 'a'
			,	'ª' => 'a'
			,	'ₐ' => 'a'
			,	'Ć' => 'C'
			,	'ć' => 'c'
			,	'Ç' => 'C'
			,	'ç' => 'c'
			,	'Ð' => 'D'
			,	'đ' => 'd'
			,	'È' => 'E'
			,	'è' => 'e'
			,	'É' => 'E'
			,	'é' => 'e'
			,	'Ê' => 'E'
			,	'ê' => 'e'
			,	'Ë' => 'E'
			,	'ë' => 'e'
			,	'ₑ' => 'e'
			,	'ƒ' => 'f'
			,	'Ì' => 'I'
			,	'ì' => 'i'
			,	'Í' => 'I'
			,	'í' => 'i'
			,	'Î' => 'I'
			,	'î' => 'i'
			,	'Ï' => 'Ii'
			,	'ï' => 'ii'
			,	'Ñ' => 'N'
			,	'ñ' => 'n'
			,	'ⁿ' => 'n'
			,	'Ò' => 'O'
			,	'ò' => 'o'
			,	'Ó' => 'O'
			,	'ó' => 'o'
			,	'Ô' => 'O'
			,	'ô' => 'o'
			,	'Õ' => 'O'
			,	'õ' => 'o'
			,	'Ø' => 'O'
			,	'ø' => 'o'
			,	'ₒ' => 'o'
			,	'Ö' => 'Oe'
			,	'ö' => 'oe'
			,	'Œ' => 'Oe'
			,	'œ' => 'oe'
			,	'ß' => 'ss'
			,	'Š' => 'S'
			,	'š' => 's'
			,	'™' => 'TM'
			,	'Ù' => 'U'
			,	'ù' => 'u'
			,	'Ú' => 'U'
			,	'ú' => 'u'
			,	'Û' => 'U'
			,	'û' => 'u'
			,	'Ü' => 'Ue'
			,	'ü' => 'ue'
			,	'Ý' => 'Y'
			,	'ý' => 'y'
			,	'ÿ' => 'y'
			,	'Ž' => 'Z'
			,	'ž' => 'z'
			// misc
			,	'¢' => 'Cent'
			,	'€' => 'Euro'
			,	'‰' => 'promille'
			,	'№' => 'Nummer'
			,	'℃' => 'Grad Celsius'
			,	'°C' => 'Grad Celsius'
			,	'℉' => 'Grad Fahrenheit'
			,	'°F' => 'Grad Fahrenheit'
			// Superscripts
			,	'⁰' => '0'
			,	'¹' => '1'
			,	'²' => '2'
			,	'³' => '3'
			,	'⁴' => '4'
			,	'⁵' => '5'
			,	'⁶' => '6'
			,	'⁷' => '7'
			,	'⁸' => '8'
			,	'⁹' => '9'
			// Subscripts
			,	'₀' => '0'
			,	'₁' => '1'
			,	'₂' => '2'
			,	'₃' => '3'
			,	'₄' => '4'
			,	'₅' => '5'
			,	'₆' => '6'
			,	'₇' => '7'
			,	'₈' => '8'
			,	'₉' => '9'
			// Operators, punctuation
			,	'±' => 'plusminus'
			,	'×' => 'x'
			,	'₊' => 'plus'
			,	'₌' => '='
			,	'⁼' => '='
			,	'⁻' => '-'   //sup minus
			,	'₋' => '-'   //sub minus
			,	'–' => '-'   //ndash
			,	'—' => '-'   //mdash
			,	'‑' => '-'   //non breaking hyphen
			,	'․' => '.'    //one dot leader
			,	'‥' => '..'  //two dot leader
			,	'…' => '...' //ellipsis
			,	'‧' => '.'   //hyphenation point
		);

		$title = strtr($title, $utf8);

		return sanitize_title_with_dashes($title);
	}

	/**
	 * Blocks update checks for this plugin.
	 *
	 * @author Mark Jaquith http://markjaquith.wordpress.com
	 * @link   http://wp.me/p56-65
	 * @param  array $r
	 * @param  string $url
	 * @return array
	 */
	static function no_upgrade_check($r, $url)
	{
		if ( 0 !== strpos(
				$url
			,	'http://api.wordpress.org/plugins/update-check'
			)
		)
		{ // Not a plugin update request. Bail immediately.
			return $r;
		}

		$plugins = unserialize( $r['body']['plugins'] );
		$p_base  = plugin_basename( __FILE__ );

		unset (
			$plugins->plugins[$p_base],
			$plugins->active[array_search($p_base, $plugins->active)]
		);

		$r['body']['plugins'] = serialize($plugins);

		return $r;
	}
}