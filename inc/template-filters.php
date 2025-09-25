<?php
/**
 * Template filters.
 *
 * @since 3.0.0
 * @package OpenAgenda
 */

add_filter( 'openagenda_event_navigation', 'openagenda_event_navigation_legacy_html', 5, 4 );
/**
 * Filters event navigation html.
 * Provides legacy HTML when legacy templates are used.
 *
 * @param  string $html  Original HTML.
 * @param  string $previous_link  Previous link HTML.
 * @param  string $next_link  Next link HTML.
 * @param  string $back_link  List link HTML.
 * @return  string  $html
 */
function openagenda_event_navigation_legacy_html( $html, $previous_link, $next_link, $back_link ) {
	if ( openagenda_use_legacy_templates() ) {
		$html = sprintf(
			'<nav class="oa-event-navigation">%s%s%s</nav>',
			$previous_link,
			$back_link,
			$next_link
		);
	}
	return $html;
}

add_filter( 'openagenda_adjacent_event_link', 'openagenda_adjacent_event_link_legacy_html', 5, 3 );
/**
 * Filters event adjacent link html.
 * Provides legacy HTML when legacy templates are used.
 *
 * @param  string $html  Original HTML.
 * @param  string $uid  Event UID.
 * @param   string $direction  'next' or 'previous'.
 * @return  string  $html
 */
function openagenda_adjacent_event_link_legacy_html( $html, $uid, $direction ) {
	global $openagenda;
	if ( openagenda_use_legacy_templates() ) {
		$encoded_context = isset( $_GET['context'] ) ? $_GET['context'] : false;
		$context         = openagenda_decode_context( $encoded_context );

		$html = '';
		if ( $context ) {
			$total        = ! empty( $context['total'] ) ? (int) $context['total'] : 0;
			$event_offset = ! empty( $context['event_offset'] ) ? (int) $context['event_offset'] : 0;
			$invalid      = 'next' === $direction ? (bool) ( ( $event_offset + 1 ) >= $total ) : (bool) ( $event_offset <= 0 );

			$url = add_query_arg(
				array(
					'action'    => 'get_adjacent_event',
					'nonce'     => wp_create_nonce( 'get_adjacent_event' ),
					'uid'       => $openagenda->get_uid(),
					'direction' => 'next' === $direction ? 'next' : 'previous',
					'context'   => $encoded_context,
				),
				admin_url( 'admin-post.php' )
			);

			$next_label     = sprintf( '<span>%s</span>%s', esc_html_x( 'Next event', 'event navigation', 'openagenda' ), openagenda_icon( 'next', false ) );
			$previous_label = sprintf( '%s<span>%s</span>', openagenda_icon( 'previous', false ), esc_html_x( 'Previous event', 'event navigation', 'openagenda' ) );

			if ( $invalid ) {
				$html = sprintf(
					'<span class="oa-nav-link oa-%1$s-link oa-nav-link-disabled">%2$s</span>',
					esc_attr( $direction ),
					'previous' === $direction ? $previous_label : $next_label
				);
			} else {
				$html = sprintf(
					'<a class="oa-nav-link oa-%1$s-link" href="%2$s">%3$s</a>',
					esc_attr( $direction ),
					esc_url( $url ),
					'previous' === $direction ? $previous_label : $next_label
				);
			}
		}
	}

	return $html;
}


add_filter( 'openagenda_back_link', 'openagenda_back_link_legacy_html', 5, 4 );
/**
 * Filters event adjacent link html.
 * Provides legacy HTML when legacy templates are used.
 *
 * @param  string $html  Original HTML.
 * @param  string $page_url  URL to list page.
 * @param   int    $page  Page number.
 * @param   array  $context  Decoded context.
 * @return  string  $html
 */
function openagenda_back_link_legacy_html( $html, $page_url, $page, $context ) {
	if ( openagenda_use_legacy_templates() ) {
		if ( $context ) {
			$total        = ! empty( $context['total'] ) ? (int) $context['total'] : 0;
			$event_offset = ! empty( $context['event_offset'] ) ? (int) $context['event_offset'] : 0;
			$event_number = $event_offset + 1;

			if ( $page_url ) {
				$html = sprintf(
					'<a class="oa-nav-link oa-back-link" href="%s">%s<span>%d / %d</span></a>',
					esc_url( $page_url ),
					openagenda_icon( 'home', false ),
					(int) $event_number,
					(int) $total
				);
			}
		}
	}
	return $html;
}
