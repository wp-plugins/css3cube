/**
 * Created by leodue on 09/04/15.
 */
var wW = window.innerWidth,
    wH = window.innerHeight,
    lato = ( wW >= wH ) ?  (wH*0.80): (wW*0.80),
    trans = Math.floor(lato / 2),
    box =  box || document.querySelector('.cube');


/*------------------------------------------------------*\
 add listener for click event on customizer panels-section
 \*------------------------------------------------------*/

function receiveMessage(even)
{


    panelClass = even.data;
    sidesAcc = {
        front  : "translateZ(-" + trans + "px) rotateY(0deg)",    //1
        back   : "translateZ(-" + trans + "px) rotateY(179.9deg)",//2
        left   : "translateZ(-" + trans + "px) rotateY(90deg)",   //3
        right  : "translateZ(-" + trans + "px) rotateY(-90deg)",  //4
        top    : "translateZ(-" + trans + "px) rotateX(-90deg)",  //5
        bottom : "translateZ(-" + trans + "px) rotateX(90deg)"    //6
    };
    box.style.transform = sidesAcc[panelClass];


}
window.addEventListener('message' , receiveMessage, false);
