<div class="off-canvas-wrapper">

	@include('partials.offcanvas')

	<div class="off-canvas-content" data-off-canvas-content>
		
		@include('partials.header')

		@if ( ( $post_id = get_queried_object()->ID ) && get_field( 'banner_setting', $post_id ) != 'hide' ) {{-- global, hide, unique, null --}}

			@php $banner_setting = get_field( 'banner_setting', $post_id ) ?: 'global'; @endphp

			@include('partials.notification-banner', [ 
				'post_id' 				=> $post_id, 
				'banner_setting' 		=> $banner_setting,
				'banner_editor' 		=> $banner_setting == 'unique' ? get_field( 'banner_editor', $post_id ) : get_field( 'banner_global_editor', 'options' ),
				'banner_include_button' => $banner_setting == 'unique' ? get_field( 'banner_include_button', $post_id ) : get_field( 'banner_global_include_button', 'options' ),
				'banner_button' 		=> $banner_setting == 'unique' ? get_field( 'banner_button', $post_id ) : get_field( 'banner_global_button', 'options' ),
				'is_active'				=> get_field( 'banner_global_include', 'options'),
				'is_expirable'			=> get_field( 'banner_global_is_expirable', 'options'),
				'is_scheduled'			=> get_field( 'banner_global_is_scheduled', 'options'),
				'expiration_date'		=> get_field( 'banner_global_expiration_date', 'options'),
				'scheduled_date'		=> get_field( 'banner_global_scheduled_date', 'options'),
			] )
		
		@endif

		<div class="container">

			<main class="content" id="main">
				@yield('content')
			</main>

		</div>

		@include('partials.footer')

	</div>

</div>