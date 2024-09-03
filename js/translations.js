var translations_json = {
  bible: {
    LV: "Bībele",
    EN: "Bible",
    LT: "",
    EE: "",
    RU: "",
    DE: "",
  },
  comments: {
    LV: "Komentāri",
    EN: "Comments",
    LT: "",
    EE: "",
    RU: "",
    DE: "",
  },
  paraugs: {
    LV: "",
    EN: "",
    LT: "",
    EE: "",
    RU: "",
    DE: "",
  },
};

function translate_all_tags(lang) {
  hideAllDropdownMenu();

  for (var key in translations_json) {
    var name = "";
    if (translations_json[key].hasOwnProperty(lang)) {
      name = translations_json[key][lang];
    }
    if (name == "") {
      name = translations_json[key]["LV"];
    }
    $(".tr_" + key).html(name);
  }
}
