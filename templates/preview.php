<?php
/**
 * Template part for displaying the preview widget
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @var     $atts       Shortcode attributes
 * @package OpenAgenda
 */
$permalink = openagenda_event_permalink( false, false, false, $atts['links'] === 'oa' );
$additional_attributes = $atts['links'] === 'oa' ? 'target="_blank" rel="noopener noreferer"' : '';
?>
<div class="oa-preview-event oa-preview-card">
    <div class="oa-card">
        <a class="oa-card-image-link" href="<?php echo $permalink; ?>" <?php echo $additional_attributes; ?>>
            <?php openagenda_event_image(); ?>
        </a>
        <div class="oa-card-body">
            <a class="oa-card-link" href="<?php echo $permalink; ?>" <?php echo $additional_attributes; ?>>
                <strong><?php openagenda_field( 'title' ); ?></strong>
            </a>
            <ul class="oa-card-metas oa-list-unstyled">
                <li class="oa-card-meta">
                    <?php openagenda_icon( 'month' ); ?>
                    <span class="oa-card-range"><?php openagenda_field( 'dateRange' ); ?></span>
                </li>
                <li class="oa-card-meta">
                    <?php openagenda_icon( 'location' ); ?>
                    <span class="oa-card-location"><?php openagenda_field( 'location.name' ); ?></span>
                </li>
            </ul>
        </div>
    </div>
</div>
