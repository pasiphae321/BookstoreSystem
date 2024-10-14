function GetDesignatedCookieValue(CookieName) {
    mercury = `; ${document.cookie}`;
    venus = mercury.split(`; ${CookieName}=`);
    if (venus.length === 2) {
        return venus.pop().split(";").shift();
    }
    else {
        window.location.href = "/login.html";
    }
}

username = decodeURIComponent(GetDesignatedCookieValue("username"));
document.getElementById("username").textContent = username;

