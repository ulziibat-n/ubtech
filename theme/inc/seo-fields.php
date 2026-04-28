<?php declare(strict_types=1);
/**
 * Advanced Premium SEO Fields via ACF Pro.
 * 
 * @package ulziibat-tech
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key'    => 'group_site_seo_settings',
		'title'  => 'SEO & Social Тохиргоо',
		'fields' => array(
			array(
				'key'   => 'tab_seo_general',
				'label' => 'Үндсэн SEO',
				'type'  => 'tab',
			),
			array(
				'key'          => 'field_site_focus_keyphrase',
				'label'        => 'Focus Keyphrase',
				'name'         => '_site_focus_keyphrase',
				'type'         => 'text',
				'instructions' => 'Энэ хуудасны зорилтот түлхүүр үгийг оруулна уу.',
			),
			array(
				'key'          => 'field_site_related_keyphrases',
				'label'        => 'Related Keyphrases',
				'name'         => '_site_related_keyphrases',
				'type'         => 'textarea',
				'rows'         => 2,
				'instructions' => 'Холбоотой түлхүүр үгсийг таслалаар тусгаарлан бичнэ үү.',
			),
			array(
				'key'          => 'field_site_seo_title',
				'label'        => 'SEO Гарчиг (Meta Title)',
				'name'         => '_site_seo_title',
				'type'         => 'text',
				'instructions' => 'Хоосон орхивол үндсэн гарчгийг ашиглана.',
			),
			array(
				'key'          => 'field_site_seo_description',
				'label'        => 'SEO Тайлбар (Meta Description)',
				'name'         => '_site_seo_description',
				'type'         => 'textarea',
				'rows'         => 3,
			),
			array(
				'key'   => 'field_site_seo_keywords',
				'label' => 'Түлхүүр үгс (Keywords)',
				'name'  => '_site_seo_keywords',
				'type'  => 'text',
			),
			array(
				'key'   => 'tab_seo_social',
				'label' => 'Social Media',
				'type'  => 'tab',
			),
			array(
				'key'          => 'field_site_social_title',
				'label'        => 'Social Title',
				'name'         => '_site_social_title',
				'type'         => 'text',
				'instructions' => 'Facebook, Twitter-т харагдах тусгай гарчиг.',
			),
			array(
				'key'          => 'field_site_social_description',
				'label'        => 'Social Description',
				'name'         => '_site_social_description',
				'type'         => 'textarea',
				'rows'         => 3,
			),
			array(
				'key'           => 'field_site_social_image',
				'label'         => 'Social Image (OG Image)',
				'name'          => '_site_social_image',
				'type'          => 'image',
				'return_format' => 'url',
				'instructions'  => '1200x630px хэмжээтэй зураг тохиромжтой.',
			),
		),
		'location' => array(
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ),
			),
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ),
			),
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'courses' ),
			),
			array(
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'portfolio' ),
			),
		),
		'menu_order' => 10,
		'position'   => 'normal',
		'style'      => 'default',
	) );

endif;
