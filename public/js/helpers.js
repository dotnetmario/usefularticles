$(document).ready(function() {
    // custom alert function
    window.alert_user = (msg, typ, pos, fadIn) => {
        // selects the alert with the proper position
        let alert = $(`#${pos}_alert`);

        // set the color of the alert
        alert.addClass(`alert-${typ}`);
        alert.removeClass(`d-none`);

        // set the alert message
        alert.find('.message').text(msg);

        // show the alert
        alert.alert();

        // close the alert after a set amount of time
        setTimeout(() => {
            alert.addClass(`d-none`);
            alert.removeClass(`alert-${typ}`);
            // alert.alert('close');
        }, (fadIn * 1000));
    }

    // get url params
    window.url_params = (del, pos) => {
        let url = window.location.href;
        let split_url = url.split(del);

        if(pos < 0)
            return split_url[split_url.length - 1];
        else
            return split_url[pos];
    }
});