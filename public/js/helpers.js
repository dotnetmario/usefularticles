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
});