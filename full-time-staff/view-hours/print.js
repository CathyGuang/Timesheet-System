var myTab = document.getElementById('HoursTable');





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


function genPDF(){

    var doc = new jsPDF();

    doc.setFontSize(16);
    doc.text(someone+"'s Total Hours "+hours,20,20);

    doc.setFontSize(12);
    doc.text("File created on "+today,20,30);

    var amount = 20;

    for (i = 1; i < myTab.rows.length; i++) {
    
        // GET THE CELLS COLLECTION OF THE CURRENT ROW.
        var objCells = myTab.rows.item(i).cells;
    
        // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
        for (var j = 0; j < objCells.length; j++) {
            doc.text(objCells.item(j).value,20,30+amount); 
            amount = amount + 10;
        }
        amount = amount + 10;
    };

    doc.addPage();
    doc.text(20,20,"TEST");
    doc.save(someone+" "+today+" hours.pdf");


};



