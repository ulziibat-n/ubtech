<?php
declare(strict_types=1);

/**
 * FAQ Block Fields
 *
 * @package ulziibat-tech
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group( array(
		'key'      => 'group_faq_block',
		'title'    => 'Block: FAQ',
		'fields'   => array(
			array(
				'key'          => 'field_faq_items',
				'label'        => 'FAQ Items',
				'name'         => 'faq_items',
				'type'         => 'repeater',
				'instructions' => 'Add questions and answers for the FAQ.',
				'required'     => 1,
				'layout'       => 'block',
				'button_label' => 'Add Item',
				'sub_fields'   => array(
					array(
						'key'      => 'field_faq_question',
						'label'    => 'Question',
						'name'     => 'question',
						'type'     => 'text',
						'required' => 1,
					),
					array(
						'key'      => 'field_faq_answer',
						'label'    => 'Answer',
						'name'     => 'answer',
						'type'     => 'wysiwyg',
						'required' => 1,
						'tabs'     => 'visual',
						'toolbar'  => 'basic',
						'media_upload' => 0,
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'block',
					'operator' => '==',
					'value'    => 'acf/faq',
				),
			),
		),
	) );
}
