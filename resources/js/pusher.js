const channel = window.Echo.channel('my-public-channel');
channel.listen('my-new-event', function(data) {
    alert(JSON.stringify(data));
});