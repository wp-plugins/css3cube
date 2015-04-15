/**
 * Created by leodue on 07/04/15.
 */
var init = function() {





/*create function to send msg to iframe*/
    function setupTransformProxy(e){
        var frames = window.frames;
        var iframe = frames[0],
        panelRot = this.id.slice(26);

        iframe.postMessage(panelRot, '*');

    }



    [].slice.call(document.querySelectorAll("[id^='accordion-section-section_']")).forEach(function(ell) {
        ell.addEventListener("click", setupTransformProxy, false);
    });




}


window.addEventListener( 'DOMContentLoaded', init, false);