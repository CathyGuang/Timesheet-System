
// transform time-stamp to readible date
function stampToDate(n){
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    return m + "/" + d + "/" + y;
}

function addTwoWeeks(n,k){
    return n + k*12096e5;
}

function minusTwoWeeks(n,k){
    return n - k*12096e5;
}

// get today's date
n =  new Date();
todayDate = stampToDate(n);
document.getElementById("date").innerHTML =todayDate;

// find next due date
const timeStampNow = Date.now();
var timeStart = new Date("2021-06-27 23:59:59");
var startStartDate = new Date("2021-06-14 23:59:59");
var startPayDate = new Date("2021-07-09 23:59:59");
var timeStampDue = timeStart.getTime();
var nextStartStamp = startStartDate.getTime();
var nextDueStamp = 0;
var nextPayStamp = startPayDate .getTime();

// CAUTION: the function only works 200 fortnights after start date, needs periodic renew
for (let i = 0; i < 200; i++) {
    if(timeStampDue>= timeStampNow){
        nextDueStamp = timeStampDue;
    }
    else{
        timeStampDue = timeStampDue + 12096e5;
        nextPayStamp = nextPayStamp + 12096e5;
        nextStartStamp = nextStartStamp + 12096e5;
    }   
}

Due_day = new Date(nextDueStamp);
nextDueDate = stampToDate(Due_day);

//if due date is today, say is today. if not, show next due date
if(nextDueDate ==todayDate ){
    document.getElementById("dueDate").innerHTML = "IS TODAY!!!";
    document.getElementById("dueDate").style.color = "#e3191c";
    document.getElementById("next_due_day").style.backgroundColor = "#fed976";
}
else{
    document.getElementById("dueDate").innerHTML = nextDueDate;
}

document.getElementById("1_start_date").innerHTML = stampToDate(new Date(nextStartStamp));
document.getElementById("1_end_date").innerHTML = nextDueDate;
document.getElementById("1_pay_date").innerHTML = stampToDate(new Date(nextPayStamp));




