
// get today's date
n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
document.getElementById("date").innerHTML = m + "/" + d + "/" + y;



// find next due date
const timeStampNow = Date.now();
var timeStart = new Date("2021-07-09 23:59:59");
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




document.getElementById("dueDate").innerHTML = nextDueStamp;



