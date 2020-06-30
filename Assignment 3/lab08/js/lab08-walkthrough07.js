/* add code here */
var daysOfWeek = new Array("Mon", "Tues", "Wed", "Thur", "Fri");
daysOfWeek.push("Sat");
daysOfWeek.unshift("Sun");
// document.write(daysOfWeek + "<br>");
document.write("<table	border=1>");
document.write("<tr>");
for (var i = 0; i < daysOfWeek.length; i++) {
  if (daysOfWeek[i].length < 4)
    {day = daysOfWeek[i];}
  else
    {day = "<em>" + daysOfWeek[i] + "</em>";}
  document.write("<th>" + day + "</th>");
}
document.write("</tr>");
document.write("<tr>");
var cal = 1;
for (var j = 0; j < 30; j++){
  document.write("<td>"+cal+"</td>");
  if (cal % 7 == 0){
    document.write("</tr><tr>");
  }
  cal++;
}
document.write("</tr>");
document.write("</table>");
