jQuery(document).ready(function( $ ) {
    console.log("toolbar: "+$('#wp-media-grid').length);
    var time = 0;
    if($('#wp-media-grid').length > 0){time = 2000;}
    setTimeout(() => {
        $('select').SumoSelect();
    }, time);
});
jQuery( window ).on( "load", function( $ ) {
    var fullScreen = document.getElementsByClassName("is-fullscreen-mode");
    if ( fullScreen.length === 0){
         //--- animation in ---
        jQuery("#adminmenumain" ).fadeIn( 250, "swing", ()=> {
            jQuery("#wpbody-content" ).slideDown( 250, "swing" )
        });
    }else{
         //--- animation in ---
        jQuery("#wpbody-content" ).slideDown( 250, "swing")
    }
} );