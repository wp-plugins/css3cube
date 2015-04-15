/**
 * Created by leodue on 08/01/15.
 */
var init = function() {
    var wW = window.innerWidth,
        wH = window.innerHeight,
        lato = ( wW >= wH ) ?  (wH*0.80): (wW*0.80),
        trans = Math.floor(lato / 2),
        wrap = wrap || document.querySelector('.wrap'), //? delete cache for orientation adjustment on tablet screen
        box =  box || document.querySelector('.cube'),         //wrap.children[0],
        boxFigure =  boxFigure || document.querySelectorAll('.cube figure');


    //setting initial translation on .cube
    box.style.transform= "translateZ(-"+ trans +"px)" ;


    //    resize the box
    wrap.style.height= lato +"px";
    wrap.style.width= lato  +"px";


    //  construct translate-- the CUBE sides
    var faces = {
        front:"rotateY(0deg) translateZ("+trans+"px)",
        back:"rotateY(180deg) translateZ("+trans+"px)" ,
        left:"rotateY(270deg) translateZ("+trans+"px)" ,
        right:"rotateY(90deg) translateZ("+trans+"px)",
        top:"rotateX(90deg) translateZ("+trans+"px)" ,
        bottom:"rotateX(270deg) translateZ("+trans+"px)"
    };


    for (var i = 0; i < boxFigure.length; ++i){
        var side = boxFigure[i].className;
        boxFigure[i].style.transform = faces[side]
    };

/*------------*\
cube movement
\*------------*/
    var rotationX=0,
        rotationY=0;

    function onButtonClick(e) {

        var rot = this.className.slice(5),
            step = 90;

       switch(true){
            /*rotation on horizontal plane*/
            case  (rot === 'right' && rotationX==0 ):
                    rotationY -= step;
                break;
            case  (rot === 'left'  && rotationX==0 ):
                    rotationY += step;
                break;
            /*rotation from horizontal plane to top||bottom sides*/
            case  (rot === 'up' && rotationX==0 ):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)}
                else if(rotationY <= -360){rotationY = rotationY-(rotationY%360)}
                else   {rotationY = 0};
                rotationX -= step;
                break;
            case (rot === 'down' && rotationX==0 ):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)}
                else if(rotationY <= -360){rotationY = rotationY-(rotationY%360)}
                else   {rotationY = 0};
                rotationX += step;
                break;
            /*rotation from top side  */
            case (rotationX==-90 && rot === 'left'):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)+90}
                else if(rotationY <= -360){rotationY = rotationY+(rotationY%360)+90}
                else   {rotationY = 90};
                rotationX=0;
                break;
            case (rotationX==-90 && rot === 'right'):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)-90}
                else if(rotationY <= -360){rotationY = rotationY+(rotationY%360)-90}
                else   {rotationY = 270};
                rotationX=0;
                break;
            case (rotationX==-90 && rot === 'up'):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)+180}
                else if(rotationY <= -360){rotationY = rotationY+(rotationY%360)-180}
                else   {rotationY = 180};
                rotationX=0;
                break;
            case (rotationX==-90 && rot === 'down'):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)}
                else if(rotationY <= -360){rotationY = rotationY-(rotationY%360)}
                else   {rotationY = 0};
                 rotationX=0;
                break;
            /*rotation from bottom side */
            case (rotationX==90 && rot === 'left'):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)-90}
                else if(rotationY <= -360){rotationY = rotationY-(rotationY%360)-90}
                else   {rotationY = 270};
                rotationX=0;
                break;
            case (rotationX==90 && rot === 'right'):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)+90}
                else if(rotationY <= -360){rotationY = rotationY+(rotationY%360)+90}
                else   {rotationY = 90};
                rotationX=0;
                break;
            case (rotationX==90 && rot === 'up'):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)}
                else if(rotationY <= -360){rotationY = rotationY+(rotationY%360)}
                else   {rotationY = 0};
                rotationX=0;
                break;
            case (rotationX==90 && rot === 'down'):
                if      (rotationY >= 360){rotationY = rotationY-(rotationY%360)+180}
                else if(rotationY <= -360){rotationY = rotationY+(rotationY%360)-180}
                else   {rotationY = 180};
                rotationX=0;
                break;

        }
        box.style.transform = "translateZ(-"+ trans +"px) rotateX("+ rotationX +"deg) rotateY("+ rotationY +"deg)";




    }
    [].slice.call(document.querySelectorAll("[class^='show-']")).forEach(function(el) {
        el.addEventListener("click", onButtonClick, false);
    });









    /*--------------------------------*\
     cube movement inside customizer this has to happen inside customizer
     cube.js is just related to iframe
     \*--------------------------------*/



//    function accordionClick(e) {
//
//        var rotAcc = this.className.slice(17),
//            sidesAcc = {
//                section_front  : "translateZ(-" + trans + "px) rotateY(0deg)",    //1
//                section_back   : "translateZ(-" + trans + "px) rotateY(179.9deg)",//2
//                section_left   : "translateZ(-" + trans + "px) rotateY(90deg)",   //3
//                section_right  : "translateZ(-" + trans + "px) rotateY(-90deg)",  //4
//                section_top    : "translateZ(-" + trans + "px) rotateX(-90deg)",  //5
//                section_bottom : "translateZ(-" + trans + "px) rotateX(90deg)"    //6
//                };
//
//
//        //box.style.transform = sidesAcc[rotAcc];
//        console.log(rotAcc);
//    }
//    [].slice.call(document.querySelectorAll("h3.accordion-section-title")).forEach(function(ell) {
//        ell.addEventListener("click", accordionClick, false);
//    });



    //document.querySelector("h3.accordion-section-title").style.background = 'red';

//function for line-height
    function getLineHeight(element){
        var temp = document.createElement(element.nodeName);
        temp.setAttribute("style","margin:0px;padding:0px;font-family:"+element.style.fontFamily+";font-size:"+element.style.fontSize);
        temp.innerHTML = "test";
        temp = element.parentNode.appendChild(temp);
        var ret = temp.clientHeight;
        temp.parentNode.removeChild(temp);
        return ret;
    }


    var contentSpan = document.querySelectorAll('span.content'),
        boxArticle =  boxArticle || document.querySelector('.cube article'),
        titleH2 = titleH2 || document.querySelectorAll('.cube h2'),
        contentLineH = contentLineH || getLineHeight(contentSpan[0]),
        more = document.querySelectorAll('#more');

// loop over content and eventually shorten it

    for (var i = 0; i < contentSpan.length; ++i){

        var contentH = contentSpan[i].offsetHeight,
            titleHeight = titleH2[i].offsetHeight,
            contentHwrap = boxArticle.offsetHeight - titleHeight, //max space for content
            availContentH = contentLineH * (Math.floor(contentHwrap / contentLineH) -1 ) ,
            vertMargin = (contentHwrap - contentH)/2,
            moreNode = document.createElement("p"),
            textnode = document.createTextNode("[....]");
            moreNode.appendChild(textnode);


       if (contentH > contentHwrap){ contentSpan[i].style.height = availContentH + "px" ; more[i].appendChild(moreNode); }
       else{ titleH2[i].style.marginTop = vertMargin + "px" };

    }



}
window.addEventListener( 'DOMContentLoaded', init, false);



