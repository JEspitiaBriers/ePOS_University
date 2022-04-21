
function display_ct() {
    var x = new Date()
    var x1=x.toUTCString();// changing the display to UTC string
    document.getElementById('clock').innerHTML = x1;
    tt=display_c();
}

function display_c(){
    var refresh=1000; // Refresh rate in milli seconds
    mytime=setTimeout('display_ct()',refresh)
}
    