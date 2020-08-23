$(document).ready(function(){

    // comment on an article
    $("#comment_send").click(() => {
        let comment = $("#comment_field").val().trim();


        if(comment === ""){
            console.log("empty");
            window.alert_user("comment is empty", 'warning', 'top', 3);
        }else{
            console.log("not empty");
            window.alert_user("comment is not empty", 'success', 'top', 3);
        }
            

        // console.log(comment);
    });
});