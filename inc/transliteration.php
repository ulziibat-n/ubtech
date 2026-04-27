<?php
/**
 * Transliteration for Mongolian Cyrillic to Latin for slugs.
 *
 * @package ulziibat-tech
 */

/**
 * Transliterates Cyrillic text to Latin.
 *
 * @param string $title The title to transliterate.
 * @return string
 */
function site_transliterate_cyrillic( $title ) {
	$cyrillic = array(
		'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'ө', 'п', 'р', 'с', 'т', 'у', 'ү', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
		'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'Ө', 'П', 'Р', 'С', 'Т', 'У', 'Ү', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
	);
	$latin    = array(
		'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'o', 'p', 'r', 's', 't', 'u', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'shch', '', 'y', '', 'e', 'yu', 'ya',
		'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'o', 'p', 'r', 's', 't', 'u', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'shch', '', 'y', '', 'e', 'yu', 'ya',
	);

	return str_replace( $cyrillic, $latin, $title );
}

/**
 * Filters the title to transliterate Cyrillic characters before sanitizing.
 *
 * @param string $title The title to sanitize.
 * @param string $raw_title The original title.
 * @param string $context The context.
 * @return string
 */
function site_sanitize_title_transliterate( $title, $raw_title, $context ) {
	if ( 'save' === $context || 'query' === $context ) {
		return site_transliterate_cyrillic( $title );
	}
	return $title;
}
add_filter( 'sanitize_title', 'site_sanitize_title_transliterate', 1, 3 );
