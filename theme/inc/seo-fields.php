<?php declare(strict_types=1);
/**
 * ACF SEO Fields Configuration.
 * 
 * @package ulziibat-tech
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key'    => 'group_site_seo_settings',
		'title'  => 'Premium SEO Settings',
		'fields' => array(
			// Primary Category Selector
			array(
				'key'           => 'field_site_primary_category',
				'label'         => 'Үндсэн ангилал (Primary Category)',
				'name'          => '_site_primary_category',
				'type'          => 'select',
				'instructions'  => 'Нийтлэлийн үндсэн ангиллыг сонгоно уу. Энэ нь SEO болон Focus Keyphrase-д ашиглагдана.',
				'required'      => 0,
				'choices'       => array(),
				'allow_null'    => 1,
				'ui'            => 1,
				'ajax'          => 0,
				'return_format' => 'value',
				'wrapper'       => array( 'width' => '100%' ),
			),
			// Focus Keyphrase
			array(
				'key'   => 'field_site_focus_keyphrase',
				'label' => 'Focus Keyphrase',
				'name'  => '_site_focus_keyphrase',
				'type'  => 'text',
				'instructions' => 'Гол түлхүүр үгээ энд оруулна уу.',
				'wrapper' => array( 'width' => '50%' ),
			),
			array(
				'key'   => 'field_site_related_keyphrases',
				'label' => 'Related Keyphrases',
				'name'  => '_site_related_keyphrases',
				'type'  => 'textarea',
				'rows'  => 2,
				'wrapper' => array( 'width' => '50%' ),
			),
			// Meta Title & Description
			array(
				'key'   => 'field_site_seo_title',
				'label' => 'SEO Title',
				'name'  => '_site_seo_title',
				'type'  => 'text',
				'instructions' => 'Google хайлтад харагдах гарчиг (Max 60 chars).',
				'wrapper' => array( 'width' => '100%' ),
			),
			array(
				'key'   => 'field_site_seo_description',
				'label' => 'Meta Description',
				'name'  => '_site_seo_description',
				'type'  => 'textarea',
				'rows'  => 3,
				'instructions' => 'Google хайлтад харагдах тайлбар (Max 155 chars).',
				'wrapper' => array( 'width' => '100%' ),
			),
			array(
				'key'   => 'field_site_seo_keywords',
				'label' => 'Meta Keywords',
				'name'  => '_site_seo_keywords',
				'type'  => 'text',
				'instructions' => 'Таслалаар тусгаарласан түлхүүр үгнүүд.',
			),
			// Social Settings Tab
			array(
				'key'   => 'field_site_seo_social_tab',
				'label' => 'Social Media',
				'type'  => 'tab',
			),
			array(
				'key'   => 'field_site_social_title',
				'label' => 'Facebook/Twitter Title',
				'name'  => '_site_social_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_site_social_description',
				'label' => 'Facebook/Twitter Description',
				'name'  => '_site_social_description',
				'type'  => 'textarea',
				'rows'  => 2,
			),
			array(
				'key'   => 'field_site_social_image',
				'label' => 'Social Share Image',
				'name'  => '_site_social_image',
				'type'  => 'image',
				'return_format' => 'url',
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
				array( 'param' => 'post_type', 'operator' => '==', 'value' => 'portfolio' ),
			),
		),
		'menu_order' => 10,
		'position'   => 'normal',
		'style'      => 'default',
	) );

endif;
