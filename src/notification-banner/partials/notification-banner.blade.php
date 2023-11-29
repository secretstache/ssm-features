@php

    if( $banner_setting == 'global' && ( $is_scheduled || $is_expirable ) ) {

        $timezone = get_option('timezone_string') ? new \DateTimeZone( get_option('timezone_string') ) : new \DateTimeZone('America/Denver');

        $current_time = new \DateTime( 'now', $timezone );

        $scheduled_time = new \DateTime( $scheduled_date, $timezone );
        $end_time = new \DateTime( $expiration_date, $timezone );

    }
    
@endphp

@if ( $banner_editor && ( $banner_setting == 'unique' || ( $banner_setting == 'global' && $is_active && ( !$is_scheduled || $current_time->format('U') >= $scheduled_time->format('U') ) && ( !$is_expirable || $current_time->format('U') <= $end_time->format('U') ) ) ) )

    <div class="notification-bar">

        <div class="module text-editor">{!! $banner_editor !!}</div>

        @if ( $banner_include_button && $banner_button && $banner_button['button_url'] )
            
            <div class="module buttons">

                <div class="button-wrap">

                    @include('modules.simple-button', [ 'button' => $banner_button ])

                </div>

            </div>

        @endif

    </div>

@endif