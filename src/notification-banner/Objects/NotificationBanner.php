<?php

namespace App\Fields\Objects;

use StoutLogic\AcfBuilder\FieldsBuilder;

use App\Fields\Components\Button;

class NotificationBanner {

	public function __construct() {

		/**
		 * Notification Banner
		 */
		$notificationBanner = new FieldsBuilder('notification_banner', [
			'title'			=> 'Notification Banner',
			'menu_order'	=>	6
		]);

		$notificationBanner

			->addTrueFalse('banner_global_include', [
				'label' 	=> false,
				'ui' 		=> 1,
				'ui_on_text'  => 'Active',
				'ui_off_text' => 'Inactive',
				'wrapper'	=> [
					'width'	=> '33'
				]
			])

			->addTrueFalse('banner_global_is_scheduled', [
				'label' 	=> false,
				'ui' 		=> 1,
				'ui_on_text'  => 'Scheduled',
				'ui_off_text' => 'Not Scheduled',
				'wrapper'	=> [
					'width'	=> '34'
				]
			])
				->conditional( 'banner_global_include', '==', 1 )

			->addTrueFalse('banner_global_is_expirable', [
				'label' 	=> false,
				'ui' 		=> 1,
				'ui_on_text'  => 'Expirable',
				'ui_off_text' => 'Never Expire',
				'wrapper'	=> [
					'width'	=> '33'
				]
			])
				->conditional( 'banner_global_include', '==', 1 )

			->addDateTimePicker('banner_global_scheduled_date', [
				'label'        		=> 'Scheduled Date',
				'display_format'	=> 'm/d/Y g:i a',
				'return_format'		=> 'm/d/Y H:i:s'
			])
				->conditional( 'banner_global_include', '==', 1 )
					->and( 'banner_global_is_scheduled', '==', 1 )

			->addDateTimePicker('banner_global_expiration_date', [
				'label'        		=> 'Expiration Date',
				'display_format'	=> 'm/d/Y g:i a',
				'return_format'		=> 'm/d/Y H:i:s'
			])
				->conditional( 'banner_global_include', '==', 1 )
					->and( 'banner_global_is_expirable', '==', 1 )
					
			->addWysiwyg('banner_global_editor', [
				'label'        => 'Description',
				'toolbar'      => 'basic',
				'media_upload' => '0',
			])
				->conditional('banner_global_include', '==', 1)

			->addTrueFalse('banner_global_include_button', [
				'label'         => false,
				'message'       => 'Include Button',
				'default_value' => 0,
			])
				->conditional('banner_global_include', '==', 1)

			->addGroup('banner_global_button', [
				'label'			=> false
			])
				->conditional('banner_global_include_button', '==', 1)

				->addFields(Button::getFields())

			->endGroup()

			->setLocation('options_page', '==', 'acf-options-brand-settings');

		// Register Notification Banner
		add_action('acf/init', function() use ($notificationBanner) {
			acf_add_local_field_group($notificationBanner->build());
		});

		$innerNotificationBanner = new FieldsBuilder('notification_banner_inner', [
			'title'			=> 'Notification Banner',
            'position'  	=> 'acf_after_title',
			'menu_order'	=>	0,
		]);

		$innerNotificationBanner

            ->addRadio('banner_setting', [
                'label'        => false,
                'layout'       => 'horizontal',
                'choices'      => [
                    'global'   => 'Use global settings',
                    'hide'     => 'Turn off for this page',
                    'unique'   => 'Create unique banner for this page',
                ],
            ])

			->addWysiwyg('banner_editor', [
				'label'        => 'Description',
				'toolbar'      => 'basic',
				'media_upload' => '0'
			])
            	->conditional('banner_setting', '==', 'unique')

			->addTrueFalse('banner_include_button', [
				'label'         => false,
				'message'       => 'Include Button',
				'default_value' => 0,
			])
            	->conditional('banner_setting', '==', 'unique')

			->addGroup('banner_button', [
				'label'			=> false
			])
				->conditional('banner_include_button', '==', 1)

				->addFields(Button::getFields())

			->endGroup()

			->setLocation('post_type', '==', 'page')
                ->or('post_type', '==', 'post');

		// Register Inner Notification Banner
		add_action('acf/init', function() use ($innerNotificationBanner) {
			acf_add_local_field_group($innerNotificationBanner->build());
		});

    }

}