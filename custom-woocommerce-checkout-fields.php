// Add a new checkout field
function sls_filter_checkout_fields($fields){
    $fields['extra_fields'] = array(
            'skill_rating' => array(
                'type' => 'select',
                'options' => array(
                	null => __( 'Select' ), 
                	'1_0' => __( '1.0' ),
                	'1_5' => __( '1.5' ),
                	'2_0' => __( '2.0' ),
                	'2_5' => __( '2.5' ),
                	'3_0' => __( '3.0' ),
                	'3_5' => __( '3.5' ),
                	'4_0' => __( '4.0' ),
                	'4_5' => __( '4.5' ),
                	'5_0' => __( '5.0' ),
                	'5_5' => __( '5.5' ),
                	'6_0' => __( '6.0' ),
                	'6_5' => __( '6.5' ),
                	'7_0' => __( '7.0' )
                	),
                'required'      => true,
                'label' => __( 'Skill Rating' )
                ),
            'player_gender' => array(
                'type' => 'select',
                'options' => array(
                	null => __( 'Select' ), 
                	'female' => __( 'Female' ),
                	'male' => __( 'Male' )
                	),
                'required'      => true,
                'label' => __( 'Gender' )
                ),
            'player_comments' => array(
                'type' => 'textarea',
                'required'      => false,
                'label' => __( 'Comments' )
                ),
            'player_career' => array(
                'type' => 'textarea',
                'required'      => false,
                'label' => __( 'Career' )
                ),
            'annual_mtg_volunteer' => array(
                'type' => 'radio',
                'options' => array( 
                	'yes' => __( 'Yes' ),
                	'no' => __( 'No' )
                	),
                'required'      => false,
                'label' => __( 'Interested Annual Meeting Volunteer' )
                ),
            'board_member' => array(
                'type' => 'radio',
                'options' => array( 
                	'yes' => __( 'Yes' ),
                	'no' => __( 'No' )
                	),
                'required'      => false,
                'label' => __( 'Interested Board Member' )
                ),
            'party_volunteer' => array(
                'type' => 'radio',
                'options' => array( 
                	'yes' => __( 'Yes' ),
                	'no' => __( 'No' )
                	),
                'required'      => false,
                'label' => __( 'Interested Tennis Party Volunteer' )
                ),
            'tournament_volunteer' => array(
                'type' => 'radio',
                'options' => array( 
                	'yes' => __( 'Yes' ),
                	'no' => __( 'No' )
                	),
                'required'      => false,
                'label' => __( 'Interested Tournament Volunteer' )
                ),
            'skill_hobbies' => array(
                'type' => 'textarea',
                'required'      => false,
                'label' => __( 'Special Skills/Hobbies' )
                ),
            'player_birthday' => array(
                'type' => 'text',
                'placeholder' 	=> __('mm/dd/yyyy'),
                'required'      => false,
                'label' => __( 'Birthdate' )
                ),
            'roster_email_show' => array(
                'type' => 'radio',
                'options' => array( 
                	'yes' => __( 'Yes' ),
                	'no' => __( 'No' )
                	),
                'required'      => false,
                'label' => __( 'To show your email in the Roster choose No; To hide your email in the Roster choose Yes' )
                )

            );

    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'sls_filter_checkout_fields' );

// display the extra field on the checkout form
function sls_extra_checkout_fields(){ 

    $checkout = WC()->checkout(); ?>

    <div class="extra-fields">
    <h3><?php _e( 'Additional Information' ); ?></h3>

    <?php 
    // because of this foreach, everything added to the array in the previous function will display automagically
    foreach ( $checkout->checkout_fields['extra_fields'] as $key => $field ) : ?>

            <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

        <?php endforeach; ?>
    </div>

<?php }
add_action( 'woocommerce_checkout_after_customer_details' ,'sls_extra_checkout_fields' );
// Step 2 of custom checkout fields
//
// save the extra fields when checkout is processed
function sls_save_extra_checkout_fields( $order_id, $posted ){
    // don't forget appropriate sanitization if you are using a different field type
    if( isset( $posted['skill_rating'] ) && in_array( $posted['skill_rating'], array( '1_0', '1_5', '2_0', '2_5', '3_0', '3_5', '4_0', '4_5', '5_0', '5_5', '6_0', '6_5', '7_0' ) ) ) {
        update_post_meta( $order_id, '_skill_rating', $posted['skill_rating'] );
    }
    if( isset( $posted['player_gender'] ) && in_array( $posted['player_gender'], array( 'male', 'female' ) ) ) {
        update_post_meta( $order_id, '_player_gender', $posted['player_gender'] );
    }
    if( isset( $posted['player_comments'] ) ) {
        update_post_meta( $order_id, '_player_comments', sanitize_text_field( $posted['player_comments'] ) );
    }
    if( isset( $posted['player_career'] ) ) {
        update_post_meta( $order_id, '_player_career', sanitize_text_field( $posted['player_career'] ) );
    }
    if( isset( $posted['annual_mtg_volunteer'] ) && in_array( $posted['annual_mtg_volunteer'], array( 'yes', 'no' ) ) ) {
        update_post_meta( $order_id, '_annual_mtg_volunteer', $posted['annual_mtg_volunteer'] );
    }
    if( isset( $posted['board_member'] ) && in_array( $posted['board_member'], array( 'yes', 'no' ) ) ) {
        update_post_meta( $order_id, '_board_member', $posted['board_member'] );
    }
    if( isset( $posted['party_volunteer'] ) && in_array( $posted['party_volunteer'], array( 'yes', 'no' ) ) ) {
        update_post_meta( $order_id, '_party_volunteer', $posted['party_volunteer'] );
    }
    if( isset( $posted['tournament_volunteer'] ) && in_array( $posted['tournament_volunteer'], array( 'yes', 'no' ) ) ) {
        update_post_meta( $order_id, '_tournament_volunteer', $posted['tournament_volunteer'] );
    }
    if( isset( $posted['skill_hobbies'] ) ) {
        update_post_meta( $order_id, '_skill_hobbies', sanitize_text_field( $posted['skill_hobbies'] ) );
    }
    if( isset( $posted['player_birthday'] ) ) {
        update_post_meta( $order_id, '_player_birthday', sanitize_text_field( $posted['player_birthday'] ) );
    }
    if( isset( $posted['roster_email_show'] ) && in_array( $posted['roster_email_show'], array( 'yes', 'no' ) ) ) {
        update_post_meta( $order_id, '_roster_email_show', $posted['roster_email_show'] );
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'sls_save_extra_checkout_fields', 10, 2 );
