if (typeof(Storage) !== "undefined") {
    localStorage.setItem('myCat', 'Tom');
    var tt = localStorage.getItem('myCat');
    var ex = localStorage.getItem('startDate');
    var control = localStorage.getItem('controll');

    console.log(tt);
    console.log(control);
    console.log(ex);
  } else {
    // Sorry! No Web Storage support..
  }




