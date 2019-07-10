$(document).ready(function($){
    $("#menu").click(function(){
        var x = document.getElementById("mainMenu");
        if (x.style.display === "block") {
          x.style.display = "none";
        } else {
          x.style.display = "block";
        }
    });
})
