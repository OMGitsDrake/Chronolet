function parseMillis(millis){
    min = 0;
    sec = 0;

    sec = Math.floor(millis / 1000);
    dec = Math.ceil((millis / 1000 - sec)*1000);
    
    if(sec >= 60){
        min = Math.floor(sec / 60);
        sec %= 60;
    }
    sec = (sec < 10) ? "0"+sec : sec;

    return min + ':' + sec + '.' + dec;
}