jQuery(document).ready(function( $ ) {
    
    //$("#wpbody-content" ).css("display","none");
    //$("#adminmenumain").css("display","none");
    //--- move user profile into menu
    var menuWrap = $("#adminmenuwrap");
    var picture = $("#menu_user_profile_container");
    $(picture).prependTo(menuWrap);
    $(picture).css('display','block');

    //--- create brand image and add to menu WIP(probably need implementation in settings)
    var brandImg = $('<img id="ma_brand_image">');
    $(brandImg).prependTo(menuWrap);
    $(brandImg).attr("src",brandImage);

    //--- replace icons in menu
    var sourceIcons = $('#adminmenu li a .wp-menu-image');
    for (let i = 0; i < sourceIcons.length; i++) {
        var classes = $(sourceIcons[i]).attr('class');
        var iconSource = classes.replace('wp-menu-image dashicons-before ','');
        for (let j = 0; j < ma_settings.menuIcons.length; j++){
            var iconData = ma_settings.menuIcons[j];
            if(iconData.source === iconSource){
                //$('.'+iconSource).css('background-color','red');
                $('.'+iconSource).attr('style','background-image: url('+iconsURL+'menu-icon/'+iconData.icon+') !important');
                $('.'+iconSource).addClass('icon-replaced');
            }
        }
    }
  
    

    var menulinks = $("#adminmenu li a");
    $(menulinks).on( "click", function( event ) {
        event.preventDefault();
        //--- remove selected class from #adminmenu
        var currentSelected = $("#adminmenu li.wp-has-current-submenu");
        currentSelected.removeClass("wp-has-current-submenu");
        currentSelected.removeClass("wp-menu-open");
        currentSelected.addClass("wp-not-current-submenu");

        var aTarget = $(event.currentTarget);
        var ulParent = $(aTarget).parent().parent();
        $(aTarget).removeClass("wp-has-current-submenu wp-menu-open");
        $(aTarget).addClass("wp-not-current-submenu");
        //console.log('parent',ulParent);
        if( $(ulParent).attr('id') == 'adminmenu' ){
            var liMenu = $(aTarget).parent();
            //--- add/remove classe to li
            $(liMenu).addClass("wp-has-current-submenu wp-menu-open");
            $(liMenu).removeClass("wp-not-current-submenu");
            //--- add/remove classe to a
            $(aTarget).addClass("wp-has-current-submenu wp-menu-open");
            $(aTarget).removeClass("wp-not-current-submenu");
        } else {
            var liMenu = $(aTarget).parent().parent().parent();
            //--- add/remove classe to li
            $(liMenu).addClass("wp-has-current-submenu wp-menu-open");
            $(liMenu).removeClass("wp-not-current-submenu");
            //--- add/remove classe to a
            aTarget = $(liMenu).find('a').first();
            $(aTarget).addClass("wp-has-current-submenu wp-menu-open");
            $(aTarget).removeClass("wp-not-current-submenu");
        }
        //--- animation out ---
        $("#wpbody-content" ).slideUp( 250, "swing", function() {
            $("#adminmenumain" ).fadeOut( 50, "swing", function() {
                window.location.replace( $(event.currentTarget).attr('href'));
            })
        });        
    });
});

