

function change(obj){

    var valued = obj.value;

    var confirmed = confirm('Are you sure you want to change this data?'+valued);

    if (confirmed == true){

         window.location.href = 'change_data.php';
         localStorage.setItem('Change_Value', valued);

    }

}

// today's date

var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = mm + '/' + dd + '/' + yyyy;


var t = document.getElementById('HoursTable');

    if(t) {
        Array.from(t.rows).forEach((tr, row_ind) => {
            Array.from(tr.cells).forEach((cell, col_ind) => {
                console.log('Value at row/col [' + row_ind + ',' + col_ind + '] = ' + cell.textContent);
            });
        });
    }


function genPDF(){

    var doc = new jsPDF();

    doc.setFontSize(16);
    doc.text(someone+"'s Total Hours "+hours,20,20);

    doc.setFontSize(12);
    doc.text("File created on "+today,20,30);

    var amount = 20;

    doc.setFontSize(10);


    // for (let i in myTab.rows) {
    //     let row = myTab.rows[i]
    //     //iterate through rows
    //     //rows would be accessed using the "row" variable assigned in the for loop
    //     for (let j in row.cells) {
    //       let col = row.cells[j]
    //       //iterate through columns
    //       //columns would be accessed using the "col" variable assigned in the for loop
    //       doc.text(col.innerHTML,20,30+amount); 
    //       amount = amount + 10;
    //     }  
    //  };


    doc.addPage();
    doc.text(20,20,"TEST");
    doc.save(someone+" "+today+" hours.pdf");


};



