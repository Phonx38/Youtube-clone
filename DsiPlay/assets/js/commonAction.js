$(document).ready(function() {

    $(".navShowHide").on("click",function() {

        var main= $('#mainSectionContainer');

        var nav =$('#sideNavbar');

        if(main.hasClass("leftPadding")) {
            nav.hide()
        }
        else{
            nav.show();
        }

        $(main).toggleClass("leftPadding");
    })
})

function notSignedIn() {
    alert ("Please Sign In!!!!");
}