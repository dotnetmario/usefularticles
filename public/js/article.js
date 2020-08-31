$(document).ready(function(){
    // parse comment
    let parseComment = (comment, user) => {
        let html = ``;
        let comments = $('#comments');

        html = `<div class="card">
                    <h5>${ user.firstname }</h5>
                    <h6 class="text-muted">@${ user.username }</h6>
                    <p>${ comment.body }</p>
                </div>`;

        comments.prepend(html);
    }

    // comment on an article
    $("#comment_send").click(() => {
        let csrf = $('meta[name="csrf-token"]').attr('content');
        let comment = $("#comment_field").val().trim();
        let article = window.url_params('/', -1);

        // comment is empty
        if(comment === ""){
            console.log("empty");
            window.alert_user("comment is empty", 'warning', 'top', 3);
            return;
        }

        // send the comment
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            url : '/comment',
            type : 'POST',
            data : {
                article, comment
            },
            error : () => {
                window.alert_user("comment was not send success", 'warning', 'top', 4);
            },
            success : (data) => {
                if(data.success){
                    window.alert_user("comment was send success", 'success', 'top', 4);
                    parseComment(data.comment, data.user);
                }else{
                    window.alert_user("comment was not send success", 'warning', 'top', 4);
                }
            }
        });
    });
});