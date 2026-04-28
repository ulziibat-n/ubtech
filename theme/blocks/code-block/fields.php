<?php
declare(strict_types=1);

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( array(
		'key'                   => 'group_code_block',
		'title'                 => 'Code Block Settings',
		'fields'                => array(
			array(
				'key'           => 'field_code_title',
				'label'         => 'Гарчиг',
				'name'          => 'code_title',
				'type'          => 'text',
				'placeholder'   => 'Жишээ: functions.php',
			),
			array(
				'key'           => 'field_code_content',
				'label'         => 'Код',
				'name'          => 'code_content',
				'type'          => 'textarea',
				'required'      => 1,
				'rows'          => 10,
				'new_lines'     => '',
				'font'          => 'monospace',
			),
			array(
				'key'           => 'field_code_wrap',
				'label'         => 'Догол мөр ашиглах (Wrap lines)',
				'name'          => 'code_wrap',
				'type'          => 'true_false',
				'ui'            => 1,
				'default_value' => 0,
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'block',
					'operator' => '==',
					'value'    => 'acf/code-block',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	) );

endif;
