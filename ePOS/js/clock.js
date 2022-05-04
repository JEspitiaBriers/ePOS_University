
function display_ct() {
    var x = new Date()
    var xx = x.toString();
    var xx2 = xx.substring(0,25)

    
    
    //var x1=x.toUTCString();// changing the display to UTC string
    
    document.getElementById('hClock').innerHTML = xx2;
    tt=display_c();
}

function display_c(){
    var refresh=1000; // Refresh rate in milli seconds
    mytime=setTimeout('display_ct()',refresh)
}
    