<?php
/**
 * Template part for displaying the preview widget
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @var  $atts  Shortcode attributes
 * @package Openagenda
 * @deprecated 
 */
$calendar_permalink = openagenda_get_permalink( $atts['uid'] );
$event_permalink    = ! empty( get_option( 'permalink_structure' ) ) ? sprintf( '%s/{Slug}', untrailingslashit( $calendar_permalink ) ) : add_query_arg( 'oa-slug', '{Slug}', $calendar_permalink );
?>
<!--
    <div class="oa-preview-events">
    {block:Events}
        <div class="oa-preview-card">
            <div class="oa-card">
                {block:ImageUrl}
                    <a class="oa-card-image-link" href="<?php echo $event_permalink; ?>">
                        <img class="oa-card-img" src="{ImageUrl}" alt="{Title}"/>
                    </a>
                {/block:ImageUrl}
                <div class="oa-card-body">
                    <a class="oa-card-link" href="<?php echo $event_permalink; ?>">
                        <strong>{Title}</strong>
                    </a>
                    <ul class="oa-list-unstyled">
                        <li class="oa-card-meta">
                            <?php openagenda_icon( 'month' ); ?>
                            <span class="oa-card-range">{DateRange}</span>
                        </li>
                        <li class="oa-card-meta">
                            <?php openagenda_icon( 'location' ); ?>
                            <span class="oa-card-location">{LocationName}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    {/block:Events}
    </div>
-->