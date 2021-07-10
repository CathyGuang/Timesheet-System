
// transform time-stamp to readible date
function stampToDate(n){
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    return m + "/" + d + "/" + y;
}

// get today's date
n =  new Date();
document.getElementById("date").innerHTML =stampToDate(n);



// find next due date
const timeStampNow = Date.now();
var timeStart = new Date("2021-06-25 23:59:59");
var timeStampDue = timeStart.getTime();
var nextDueStamp = 0;

for (let i = 0; i < 200; i++) {

    if(timeStampDue>= timeStampNow){
        nextDueStamp = timeStampDue;
    }
    else{
        timeStampDue = timeStampDue + 12096e5;
    }   

}
Due_day = new Date(nextDueStamp);
document.getElementById("dueDate").innerHTML = stampToDate(Due_day);





