/**
 * This code creates a simple modal popup window, whenever a link with a name
 * of 'modal' is clicked. A div element with an id specified in the href tag
 * is used as the basis for the window contents
 * 
 * Code retrieved from: 
 * 
 * @link http://www.queness.com/post/77/simple-jquery-modal-window-tutorial
 */

$(document).ready(function() {  
    //select all the a tag with name equal to modal
    $('a[name=modal]').click(function(e) {
        //Cancel the link behavior
        e.preventDefault();
        //Get the A tag
        var id = $(this).attr('href');

        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();

        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});

        //transition effect     
        $('#mask').fadeIn(250);    
        $('#mask').fadeTo("fast",0.8);  

        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        $(id).css('top',  winH/2-$(id).height()/2);
        $(id).css('left', winW/2-$(id).width()/2);
        //transition effect
        $(id).fadeIn(250); 

    });

    //if close button is clicked
    $('.window .close').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        $('#mask, .window').hide();
    });     

    //if mask is clicked
    $('#mask').click(function () {
        $(this).hide();
        $('.window').hide();
    }); 

    $(window).resize(function () {
        var box = $('#boxes .window');

        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();

        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});

        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
    });
});

