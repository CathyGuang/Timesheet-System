var changed_value = localStorage.getItem('Change_Value');
var splitted_value = changed_value.split("_");
var value_id = parseInt(splitted_value[0]);
var value_idD = parseInt(splitted_value[1]);

console.log(splitted_value[0]);
console.log(splitted_value[1]);