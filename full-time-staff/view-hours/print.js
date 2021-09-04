

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


var myTab = document.getElementById('HoursTable');

function genPDF(){

    var doc = new jsPDF();

    doc.setFontSize(16);
    doc.text(someone+"'s Total Hours "+hours,20,20);

    doc.setFontSize(12);
    doc.text("File created on "+today,20,30);

    var amount = 20;

    doc.setFontSize(10);


    for (let i in myTab.rows) {
        let row = myTab.rows[i]
        if(i != 0){
            //iterate through rows
            //rows would be accessed using the "row" variable assigned in the for loop
            for (let j in row.cells) {
                let col = row.cells[j]
                //   console.log(col);
                if (j == 0){
                console.log("COL:");
                console.log(col.textContent);
                doc.text(col.textContent,20,30+amount); 
                amount = amount + 10;
                }
                if(j==1 || j==2 || j==3){
                console.log("EEEE:");
                console.log(col.children[0].value);
                doc.text(col.children[0].value,20,30+amount); 
                amount = amount + 10;
    
                }
                else{
                amount = amount + 5;
    
                }

            }
        
        }  
    };
    doc.save(someone+" "+today+" hours.pdf");


};



