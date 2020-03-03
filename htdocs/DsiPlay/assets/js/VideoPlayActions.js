

    function likeVideo(button,videoId)
    {
            $.post("ajax/likeVideo.php",{videoId: videoId})
            .done(function(data){
                var likeBtn = $(button);
                var dislikeBtn = $(button).siblings(".dislikeBtn");

                $(likeBtn).addClass("active");
                $(dislikeBtn).removeClass("active"); 

                var result = JSON.parse(data);
                updateLikes(likeBtn.find(".text"), result.likes);

                updateLikes(dislikeBtn.find(".text"), result.dislikes) ;
                console.log(result.likes);

                if(result.likes < 0) {
                    likeBtn.removeClass("active");
                    likeBtn.find("img:first").attr("src","assets/icons/thumbs-up.png")

                }
                else{
                    likeBtn.find("img:first").attr("src","assets/icons/thumbs-up-act.png");
                }
                dislikeBtn.find("img:first").attr("src","assets/icons/thumbs-down.png");
            });
    }


    function dislikeVideo(button,videoId)
    {
            $.post("ajax/dislikeVideo.php",{videoId: videoId})
            .done(function(data){
                var dislikeBtn = $(button);
                var likeBtn = $(button).siblings(".likeBtn");

                $(dislikeBtn).addClass("active");
                $(likeBtn).removeClass("active"); 

                var result = JSON.parse(data);
                updateLikes(likeBtn.find(".text"), result.likes);

                updateLikes(dislikeBtn.find(".text"), result.dislikes) ;
                console.log(result.likes);

                if(result.dislikes < 0) {
                    dislikeBtn.removeClass("active");
                    dislikeBtn.find("img:first").attr("src","assets/icons/thumbs-down.png")

                }
                else{
                    dislikeBtn.find("img:first").attr("src","assets/icons/thumbs-down-act.png");
                }
                likeBtn.find("img:first").attr("src","assets/icons/thumbs-up.png");
            });
    }

    function updateLikes(element,num)
    {
        var likesCountVal = element.text() || 0;
        element.text(parseInt(likesCountVal) + parseInt(num));
    }

