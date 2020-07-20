<?php
    wp_enqueue_style( 'adverts-frontend' );
    wp_enqueue_style( 'adverts-icons' );
    wp_enqueue_style( 'adverts-icons-animate' );
    wp_enqueue_script( 'adverts-frontend' );
    
?>

<?php do_action( "adverts_tpl_single_top", $post_id ) ?>


    
    <?php if( get_post_meta( $post_id, "adverts_price", true) ): ?>
    <div class="adverts-single-price">
        <span class="adverts-price-box"><?php echo esc_html( adverts_get_the_price( $post_id ) ) ?></span>
    </div>
    <?php elseif( adverts_config( 'empty_price' ) ): ?>
    <div class="adverts-single-price adverts-price-empty">
        <span class="adverts-price-box"><?php echo esc_html( adverts_empty_price( get_the_ID() ) ) ?></span>
    </div>
    <?php endif; ?>
</div>

<div class="adverts-grid adverts-grid-closed-top adverts-grid-with-icons adverts-single-grid-details">
<div class="adverts-single-box">
    <div class="adverts-single-author">
        <div class="adverts-single-author-avatar">
            <?php $id_or_email = get_post_field( 'post_author', $post_id ) ?>
            <?php $id_or_email = $id_or_email ? $id_or_email : get_post_meta($post_id, 'adverts_email', true) ?>
        </div>
        <div class="adverts-single-author-name">
            <?php echo apply_filters( "adverts_tpl_single_posted_by", sprintf( __("by <strong>%s</strong>", "wpadverts"), get_post_meta($post_id, 'adverts_person', true) ), $post_id ) ?><br/>
            <?php printf( __('Published: %1$s (%2$s ago)', "wpadverts"), date_i18n( get_option( 'date_format' ), get_post_time( 'U', false, $post_id ) ), human_time_diff( get_post_time( 'U', false, $post_id ), current_time('timestamp') ) ) ?>
        </div>
    </div>
</br>
 <?php   $terms = get_the_terms( $post_id, 'advert_example' );
    
   
    
     if(! empty( $terms ) ): ?>
    <div class="adverts-grid-row">
        <div class="adverts-grid-col adverts-col-30">
            <span class="adverts-row-title">Activity category</span>
        </div>
        <div class="adverts-grid-col adverts-col-65">
            <?php foreach( $terms as $term ): ?>
            <?php echo join( " / ", advert_category_path( $term ) ) ?></a><br/>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(get_post_meta( $post_id, "adverts_phone", true )): ?>
    <div class="adverts-grid-row">
        <div class="adverts-grid-col adverts-col-30">
            <span class="adverts-row-title"><?php _e("Phone", "adverts") ?></span>
        </div>
        <div class="adverts-grid-col adverts-col-65">
            <?php echo apply_filters( "adverts_tpl_single_location", esc_html( get_post_meta( $post_id, "adverts_phone", true ) ), $post_id ) ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if(get_post_meta( $post_id, "adverts_email", true )): ?>
    <div class="adverts-grid-row">
        <div class="adverts-grid-col adverts-col-30">
            <span class="adverts-row-title"><?php _e("Email", "adverts") ?></span>
        </div>
        <div class="adverts-grid-col adverts-col-65">
            <?php echo apply_filters( "adverts_tpl_single_location", esc_html( get_post_meta( $post_id, "adverts_email", true ) ), $post_id ) ?>
        </div>
    </div>
    <?php endif; ?>

        <?php if(get_post_meta( $post_id, "Address", true )): ?>
    <div class="adverts-grid-row">
        <div class="adverts-grid-col adverts-col-30">
            <span class="adverts-row-title"><?php _e("Address", "adverts") ?></span>
        </div>
        <div class="adverts-grid-col adverts-col-65">
            <?php echo apply_filters( "adverts_tpl_single_location", esc_html( get_post_meta( $post_id, "Address", true ) ), $post_id ) ?>
        </div>
    </div>
    <?php endif; ?>
        
    <?php if(get_post_meta( $post_id, "adverts_location", true )): ?>
    <div class="adverts-grid-row">
        <div class="adverts-grid-col adverts-col-30">
            <span class="adverts-round-icon adverts-icon-location"></span>
            <span class="adverts-row-title"><?php _e("Location", "adverts") ?></span>
        </div>
        <div class="adverts-grid-col adverts-col-65">
            <?php echo apply_filters( "adverts_tpl_single_location", esc_html( get_post_meta( $post_id, "adverts_location", true ) ), $post_id ) ?>
        </div>
    </div>
    <?php endif; ?>

       <?php $advert_category = get_the_terms( $post_id, 'advert_category' ) ?>
    <?php if(!empty($advert_category)): ?> 
    <div class="adverts-grid-row ">
        <div class="adverts-grid-col adverts-col-30">
             <span class="adverts-round-icon adverts-icon-location"></span>
            <span class="adverts-row-title"><?php _e("Country", "adverts") ?></span>
        </div>
        <div class="adverts-grid-col adverts-col-65">
            <?php foreach($advert_category as $c): ?> 
            <?php echo join( " / ", advert_category_path( $c ) ) ?></a><br/>
            <?php endforeach; ?>
        </div>
    </div>        
    <?php endif; ?>
    
    <?php do_action( "adverts_tpl_single_details", $post_id ) ?>
</div>

<div class="adverts-content">
    <?php echo $post_content ?>
</div>
        <?php $Address = get_post_meta( $post_id, "Address", true );   
             $Location = get_post_meta( $post_id, "adverts_location", true );
            // $Country = join( " / ", advert_category_path( $c ) );
             $all = $Address.", ".$Location;
             ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDijsd8yNKg0PnM3bfX8uaHKjhtbFYEqpw&callback=initMap"
    async defer></script>       
   <div id="map"> </div>
                </br>
               <script>

                function initMap(){  
                                        var geocoder = new google.maps.Geocoder();
                    var address = '<?php echo $all;?>';
                    geocoder.geocode( { 'address': address}, function(results, status) {

  if (status == google.maps.GeocoderStatus.OK) {
    var latitude = results[0].geometry.location.lat();
    var longitude = results[0].geometry.location.lng();
    var ltt = parseFloat(latitude);
    var lnn = parseFloat(longitude);
    var pos =  new google.maps.LatLng(ltt, lnn); 
    var opt = {center: pos, zoom: 16} 
    var map = new google.maps.Map(document.getElementById("map"), opt);
    var marker = new google.maps.Marker({
    position: pos,
    map: map
  });
    var info = new google.maps.InfoWindow({
    content: '<?php echo $all;?>'
  });
    marker.addListener("click", function(){
    info.open(map, marker);
  });
  } 
  }); 
                }
               </script>
               
                <div>
    <?php  if (function_exists('wise_chat')) { wise_chat($channel=$post_id); } ?>
               </div>
