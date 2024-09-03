var book_names = null;
var current_tr = "lv65";
var current_c = 43;
var current_b = 1;
var coments_arr = [];

function load_header(tr, b, c) {
  var url = "php/header.php?tr=" + tr + "&b=" + b + "&c=" + c;
  $.ajax({ url: url, success: function (result) {} });
}

load_header("lv65", "43", "1");
