

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

//submitted function:
function submitted() {

    var confirmed = confirm('Are you sure you want to change the pay date?');

    if (confirmed == true){

        document.getElementById('myform').submit(function(e){   
            
            //Selected new Date
            var selected = document.getElementById("new-start-date").value;
            SelectedD = new Date(selected);
            var SelectedStamp = SelectedD.getTime();
            localStorage.setItem('startDate', SelectedStamp);
            localStorage.setItem('dueDate', minus13Days(SelectedStamp));
            localStorage.setItem('payDate', add12Days(SelectedStamp));


            window.location.href = 'alter_pay.php'; 
        });
        
    }

}





if (typeof(Storage) !== "undefined") {
    localStorage.setItem('myCat', 'Tom');
    var tt = localStorage.getItem('myCat');
    var StartDate = parseInt(localStorage.getItem('startDate'));
    var EndDate = parseInt(localStorage.getItem('dueDate'));
    var PayDate = parseInt(localStorage.getItem('payDate'));
    var control = localStorage.getItem('controll');

    StartDateD = new Date(StartDate);
    EndDateD = new Date(EndDate);
    PayDateD = new Date(PayDate);


    document.getElementById("start-date").innerHTML = stampToDate(StartDateD);
    document.getElementById("end-date").innerHTML = stampToDate(EndDateD);
    document.getElementById("pay-date").innerHTML = stampToDate(PayDateD);

    console.log(tt);
    console.log(control);
    console.log(StartDateD);
    console.log(EndDateD);
    // console.log(selected);
    // console.log(SelectedD);
    // console.log(SelectedStamp);


  } else {
    // Sorry! No Web Storage support..
    document.getElementById("start-date").innerHTML = "Sorry! Your web browser does not support Web Storage";
    document.getElementById("end-date").innerHTML = "Sorry! Your web browser does not support Web Storage";
  }




