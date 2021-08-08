// transform time-stamp to readible date
function stampToDate(n){
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    return m + "/" + d + "/" + y;
}




if (typeof(Storage) !== "undefined") {
    localStorage.setItem('myCat', 'Tom');
    var tt = localStorage.getItem('myCat');
    var StartDate = parseInt(localStorage.getItem('startDate'));
    var EndDate = parseInt(localStorage.getItem('dueDate'));
    var control = localStorage.getItem('controll');

    StartDateD = new Date(StartDate);
    EndDateD = new Date(EndDate);


    document.getElementById("start-date").innerHTML = stampToDate(StartDateD);
    document.getElementById("end-date").innerHTML = stampToDate(EndDateD);

    console.log(tt);
    console.log(control);
    console.log(StartDate);
    console.log(EndDate);
    console.log(StartDateDate);
    console.log(StartDateDate);
  } else {
    // Sorry! No Web Storage support..
  }




