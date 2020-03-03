function follow(userTo , userFrom, button)
{
    if(userTo == userFrom)
    {
        alert("Cant Follow Yourself");
        return ;
    }

    $.post("ajax/follow.php",{userTo :userTo, userFrom :userFrom})
    .done(function(count){
        if(count != null)
        {
            $(button).toggleClass("follow unfollow");
            var BtnText = $(button).hasClass("follow") ? "FOLLOW" : "FOLLOWING";
            $(button).text(BtnText+"  " + count);
        }else{
            alert("Something is wrong");
        }
    });
}