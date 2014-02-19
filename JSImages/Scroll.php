<?php
    # get list of all image files
    $dir = 'img/';
    $pngfiles = glob( $dir . '*.png');
?>


<html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.cycle2.js"></script>
<div id="slideshow" class="mySlideshow" style="position: relative;overflow: hidden;height:850px;width:550px;" data-cycle-pause-on-hover="true">
    <?
    foreach($pngfiles as $file) {
    	echo '<img src="' . $file . '"><br>';
	}
    ?>
   
</div>
 <button data-cycle-cmd="pause" data-cycle-context="#slideshow">Pause</button>
 <button data-cycle-cmd="resume" data-cycle-context="#slideshow">Resume</button>
  <button data-cycle-cmd="prev" data-cycle-context="#slideshow">Previous</button>
 <button data-cycle-cmd="next" data-cycle-context="#slideshow">Next</button>

<script>
$(document).ready(function () {
   $( '.mySlideshow' ).cycle({
       
   	fx: "none",
   	timeout: 1,
        speed: 1,        
        continuous: 1
   	});
   
   var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel" //FF doesn't recognize mousewheel as of FF3.x
    $('#slideshow').bind(mousewheelevt, function(e){

        var evt = window.event || e //equalize event object     
        evt = evt.originalEvent ? evt.originalEvent : evt; //convert to originalEvent if possible               
        var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta //check for detail first, because it is used by Opera and FF

        if(delta > 0) {
            //scroll up
            $('#slideshow').cycle('prev');
        }
        else{
            //scroll down
            $('#slideshow').cycle('next');
        }   
    });	

    
});

</script>
</html>