if (typeof(Storage) !== "undefined") {
    localStorage.setItem('myCat', 'Tom');
    var ex = localStorage.getItem('startDate');
    var control = localStorage.getItem('control');
    console.log(ex);
    console.log(control);
  } else {
    // Sorry! No Web Storage support..
  }




