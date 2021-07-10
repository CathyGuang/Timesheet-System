
// get today's date
n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
document.getElementById("date").innerHTML = m + "/" + d + "/" + y;



// find next due date
const timeStampNow = Date.now();
var timeStart = new Date("2021-06-24 23:59:59");
var timeStampDue = timeStart.getTime();
var nextDueStamp = 0;

console.log(timeStampNow);
console.log(timeStampDue);
for (let i = 0; i < 200; i++) {

    if(timeStampDue>= timeStampNow){
        nextDueStamp = timeStampDue;
    }
    else{
        timeStampDue = timeStampDue + 12096e5;
    }   

}
var Due_day = new Date(nextDueStamp);
Due_y = Due_day.getFullYear();
Due_m = Due_day.getMonth() + 1;
Due_d = Due_day.getDate();
document.getElementById("dueDate").innerHTML = Due_m + "/" + Due_d + "/" + Due_y;





