$(document).ready(function ($) {
  $("#menu").click(function () {
    $("header").toggleClass("active");
  });
  
})
$(document).ready(function () {
  var url_string = window.location.href;
  var url = new URL(url_string);
  var a = url.searchParams.get("r");
  // console.log(a);
  if (a == "p01") {
    // alert("Hello! I am an alert box!!");
    jQuery("#document-1").attr("checked", true);
  } else if (a == "p02") {
    // alert("Hello! ");
    jQuery("#document-2").attr("checked", true);
  } else {
    // alert("Hello! ");
  }
});