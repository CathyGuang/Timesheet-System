
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

function add12Days(n){
    return n + 12096e5 - (2*86400000) ;
}

function minus13Days(n){
    return n - 12096e5 +86400000 ;
}


function minusTwoWeeks(n,k){
    return n - k*12096e5;
}

// get today's date
n =  new Date();
todayDate = stampToDate(n);
document.getElementById("date").innerHTML =todayDate;

var beginDate = "2021-06-27 23:59:59";

// find next due date
const timeStampNow = Date.now();
var timeStart = new Date(beginDate);
var timeStampDue = timeStart.getTime();
var nextStartStamp = minus13Days(timeStampDue);
var nextDueStamp = 0;
var nextPayStamp = add12Days(timeStampDue);

// CAUTION: the function only works 200 fortnights after start date, needs periodic renew
for (let i = 0; i < 500; i++) {
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

document.getElementById("2_start_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextStartStamp,1)));
document.getElementById("2_end_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextDueStamp,1)));
document.getElementById("2_pay_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextPayStamp,1)));

document.getElementById("3_start_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextStartStamp,2)));
document.getElementById("3_end_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextDueStamp,2)));
document.getElementById("3_pay_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextPayStamp,2)));

document.getElementById("4_start_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextStartStamp,3)));
document.getElementById("4_end_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextDueStamp,3)));
document.getElementById("4_pay_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextPayStamp,3)));

document.getElementById("5_start_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextStartStamp,4)));
document.getElementById("5_end_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextDueStamp,4)));
document.getElementById("5_pay_date").innerHTML = stampToDate(new Date(addTwoWeeks(nextPayStamp,4)));

document.getElementById("-1_start_date").innerHTML = stampToDate(new Date(minusTwoWeeks(nextStartStamp,1)));
document.getElementById("-1_end_date").innerHTML = stampToDate(new Date(minusTwoWeeks(nextDueStamp,1)));
document.getElementById("-1_pay_date").innerHTML = stampToDate(new Date(minusTwoWeeks(nextPayStamp,1)));