(function () {
    // Collect analytics data
    var analyticsData = {
        page: window.location.pathname,
        referrer: document.referrer,
    };

    // Send data to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", site_url + "/track.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify(analyticsData));
})();
