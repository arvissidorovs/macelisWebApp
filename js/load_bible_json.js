var book_names = null;
var current_tr = "lv65";
var current_c = 43;
var current_b = 1;
var coments_arr = [];

function hideAllDropdownMenu() {
  $(".dropdown").removeClass("show");
  $(".dropdown-menu").removeClass("show");
  $(".dropdown-submenu").removeClass("show");
}

function set_tr(tr) {
  hideAllDropdownMenu();
  current_tr = tr;
  load_c();
}

function load_book_names(tr) {
  var url = "php/load_book_names.php?tr=lv";

  $.ajax({
    url: url,
    success: function (result) {
      o = JSON.parse(result);
      book_names = o;
      book_names_html = "";
      if (o.length > 0) {
        var i = 0;
        while (i < o.length) {
          var b = o[i].i;
          var s = o[i].s;

          var c_html = "";
          var c_max = o[i].c;
          var ic = 1;
          while (ic <= c_max) {
            c_html =
              c_html +
              '<div class="accordion-body px-0 py-0"  onclick="onClickSetChapter(' +
              b +
              "," +
              ic +
              ')" style="display: inline-block"><a type="button" class="px-4 py-4" style="display: inline-block"><h3>' +
              ic +
              "</h3></a></div>";
            ic++;
          }
          book_names_html =
            book_names_html +
            '<div class="accordion accordion-flush bg-canvasbody" id="accordionChapter"><div class="accordion-item"><div class="accordion-header"><div class="row row_my-2_' +
            o[i].on +
            ' " style="--bs-gutter-x: 0 !important"><a type="button" class=" text-decoration-none pb-0 collapsed" id="toggleThis"><h2 id="bookSelect" class="py-0 my-2 hr-lines" data-bs-toggle="collapse" data-bs-target="#accordionPanel_' +
            b +
            '" aria-expanded="false" aria-controls="accordionPanel_' +
            b +
            '" onclick="onclickSetBook(' +
            b +
            ')">' +
            s +
            '</h2></a><div id="accordionPanel_' +
            b +
            '" class="accordion-collapse collapse px-5"">' +
            c_html +
            "</div></div></div></div></div>";
          i++;
        }
      }

      $("#book_names_list").html(book_names_html);
      $("#comment_book_names_list").html(book_names_html);
      onclickNTbutton();
      loadInitURL();
    },
  });
}

load_book_names("lv");

function onclickNTbutton() {
  $(".row_my-2_OT").hide();
  $(".row_my-2_NT").show();
}

function onclickOTbutton() {
  $(".row_my-2_NT").hide();
  $(".row_my-2_OT").show();
}

function onclickSetBook(b) {
  current_b = b;
  current_c = 1;
  load_c();
}

var jump_to_v = 1;
var selected_v = 0;

function load_header(tr, b, c) {
  var url = "php/header.php?tr=" + tr + "&b=" + b + "&c=" + c;
  $.ajax({ url: url, success: function (result) {} });
}

load_header("lv65", "43", "1");

let selectedColor = "";
let selectedVerseId = "";
let versesWithComments = {};
let colorPickerOpen = false;
let commentModalOpen = false;
let offcanvasOpen = false;

function load_c_json(tr, b, c) {
  $("#chapter_content").html(`
        <div>
            ${'<div class="placeholder-verse"></div>'.repeat(20)}
        </div>
    `);

  var url = "php/load_c_json.php?tr=" + tr + "&b=" + b + "&c=" + c;

  $.ajax({
    url: url,
    success: function (result) {
      var o = JSON.parse(result);
      var chapter_html = "";

      var url_param = tr + "/" + getBookNameAbb(b) + "/" + c + "/" + jump_to_v;
      if (history.pushState) {
        var newurl =
          window.location.protocol +
          "//" +
          window.location.host +
          window.location.pathname +
          "?" +
          url_param;
        window.history.pushState({ path: newurl }, "", newurl);

        var newTitle =
          getBookName(b) +
          " " +
          c +
          " | " +
          getTranslationMapping(tr) +
          " | Māceklis";
        document.title = newTitle;

        var description = "";
        if (o.varr) {
          var verseLimit = 3;
          for (var i = 1; i <= o.vlen && i <= verseLimit; i++) {
            var verseText = o.varr[i] ? o.varr[i].t : "";
            description += verseText;
          }
        }
        if (!description) {
          description = "Read this chapter to explore the verse...";
        }
        updateMetaTag("description", description);
        updateMetaTag("og:description", description);

        var canonicalUrl = newurl.split("?")[0];
        updateMetaTag("canonical", canonicalUrl);
      }

      if (o.b > 0) {
        var b2 = "" + o.b;
        if (b2.length == 1) {
          b2 = "0" + b2;
        }
        var c3 = "" + o.c;
        if (c3.length == 1) {
          c3 = "00" + c3;
        } else if (c3.length == 2) {
          c3 = "0" + c3;
        }
        var id5 = b2 + c3;

        var i = 1;
        var class_selected = "";
        if (jump_to_v > 1 && jump_to_v == o.varr[1].v) {
          class_selected = " selected_v";
        }

        var verseColor = o.varr[1].color || "";

        chapter_html =
          '<div id="verse_id_1">' +
          '<span class="verse first-verse ' +
          class_selected +
          '" data-key="' +
          id5 +
          '001">' +
          '<h2 class="chapter-number" data-chapter="' +
          o.c +
          '"></h2>' +
          '<span class="prose" style="font-size:1.5rem;">' +
          '<a style="background-color: ' +
          verseColor +
          ';" onclick="handleVerseClick(\'' +
          id5 +
          "001', " +
          o.b +
          ", " +
          o.c +
          ', 1)" data-bs-toggle="' +
          (hasComment(o.b, o.c, 1) ? "offcanvas" : "") +
          '" data-bs-target="' +
          (hasComment(o.b, o.c, 1) ? "#sidebar_bottom" : "") +
          '">' +
          '<span class="start-pericope"></span>' +
          o.varr[1].t +
          "</a>" +
          "</span>" +
          "</span>" +
          "</div>";

        i++;
        while (i <= o.vlen) {
          var v = o.varr[i].v;
          var t = o.varr[i].t;
          var v3 = "" + v;
          if (v3.length == 1) {
            v3 = "00" + v3;
          } else if (v3.length == 2) {
            v3 = "0" + v3;
          }

          var id8 = id5 + v3;
          var class_selected = "";

          if (jump_to_v > 1 && jump_to_v == v) {
            selected_v = 0;
            class_selected = " selected_v";
          }

          var verseColor = o.varr[i].color || "";

          chapter_html +=
            '<div id="verse_id_' +
            v +
            '">' +
            '<span class="verse ' +
            class_selected +
            '" data-key="' +
            id8 +
            '">' +
            '<small data-verse="' +
            v +
            '">' +
            '<span class="mt-1 verse">' +
            v +
            "</span>" +
            "</small>" +
            '<span class="prose" style="font-size:1.5rem;">' +
            '<a style="background-color: ' +
            verseColor +
            ';" onclick="handleVerseClick(\'' +
            id8 +
            "', " +
            o.b +
            ", " +
            o.c +
            ", " +
            v +
            ')" data-bs-toggle="' +
            (hasComment(o.b, o.c, 1) ? "offcanvas" : "") +
            '" data-bs-target="' +
            (hasComment(o.b, o.c, 1) ? "#sidebar_bottom" : "") +
            '">' +
            t +
            "</a>" +
            "</span>" +
            "</span>" +
            "</div>";
          i++;
        }
      }

      $("#chapter_content").html(chapter_html);
      if (jump_to_v == 1) {
        document.getElementById("section_bible_results").scrollIntoView();
      } else {
        setTimeout(scrollFunction, 300);
      }

      updateTitleFromUrl(tr, b, c);
      load_c_json_coments(b, c);
      load_user_comments(b, c);
    },
  });
}

function deselectVerse() {
  const oldVerseElement = document.querySelector(
    `[data-key="${selectedVerseId}"]`
  );
  if (oldVerseElement) {
    oldVerseElement.classList.remove("selected");
  }
  const offcanvas = document.getElementById("sidebar_bottom");
  document.getElementById("versePill").style.display = "none";
  if (offcanvasOpen) {
    $("#sidebar_bottom").offcanvas("hide");
    offcanvasOpen = false;
  }
  selectedVerseId = "";
}

function handleVerseClick(verseId, b, c, v) {
  const oldVerseElement = document.querySelector(
    `[data-key="${selectedVerseId}"]`
  );
  const newVerseElement = document.querySelector(`[data-key="${verseId}"]`);
  const offcanvas = document.getElementById("sidebar_bottom");
  const versePill = document.getElementById("versePill");

  if (selectedVerseId !== verseId) {
    deselectVerse();

    if (hasComment(b, c, v)) {
      show_offcanvas_comment(b, c, v);
      offcanvasOpen = true;
      versePill.style.display = "none";
    } else {
      $("#sidebar_bottom").offcanvas("hide");
      offcanvas.classList.remove("show");
      if (offcanvasOpen) {
        offcanvas.classList.remove("show");
        offcanvasOpen = false;
      }

      const rect = newVerseElement.getBoundingClientRect();
      versePill.style.display = "block";
      versePill.style.position = "absolute";
      versePill.style.left = `${rect.left + window.scrollX + 30}px`;
      versePill.style.top = `${
        rect.top + window.scrollY - versePill.offsetHeight + 10
      }px`;
      versePill.style.zIndex = "1000";
    }

    if (newVerseElement) {
      newVerseElement.classList.add("selected");
    }
    selectedVerseId = verseId;

    if (colorPickerOpen) {
      document.getElementById("colorPickerModal").style.display = "none";
      colorPickerOpen = false;
    }

    return;
  }

  if (selectedVerseId === verseId) {
    if (hasComment(b, c, v)) {
      if (newVerseElement) {
        newVerseElement.classList.remove("selected");
      }
      selectedVerseId = "";
      versePill.style.display = "none";
    } else {
      if (offcanvasOpen) {
        offcanvas.classList.remove("show");
        offcanvasOpen = false;
      }
      $("#sidebar_bottom").offcanvas("hide");
      versePill.style.display = "none";

      if (newVerseElement) {
        newVerseElement.classList.remove("selected");
      }
      selectedVerseId = "";
    }
  }
}

function showColorPicker(verseId) {
  selectedVerseId = verseId;
  let verseElement = document.querySelector(
    '[data-key="' + selectedVerseId + '"]'
  );
  let colorPickerModal = document.getElementById("colorPickerModal");

  if (colorPickerOpen) {
    colorPickerModal.style.display = "none";
    colorPickerOpen = false;
  } else {
    if (verseElement) {
      let rect = verseElement.getBoundingClientRect();
      colorPickerModal.style.display = "block";
      colorPickerModal.style.left = `${rect.left + window.scrollX + 30}px`;
      colorPickerModal.style.top = `${
        rect.top + window.scrollY + verseElement.offsetHeight
      }px`;
      colorPickerOpen = true;
    }
  }

  if (commentModalOpen) {
    document.getElementById("commentModal").style.display = "none";
    commentModalOpen = false;
  }
}

function selectColor(color) {
  selectedColor = color;
  applyColor();
}

function applyColor() {
  if (!isLoggedIn()) {
    $("#loginModal").modal("show");
    return;
  }

  let verseElement = document.querySelector(
    '[data-key="' + selectedVerseId + '"] .prose a'
  );
  if (verseElement) {
    let currentTheme = document.documentElement.getAttribute("data-theme");

    if (currentTheme === "dark") {
      verseElement.style.color = "#000000";
    }

    verseElement.style.backgroundColor = selectedColor;
  }
  document.getElementById("colorPickerModal").style.display = "none";
  document.getElementById("versePill").style.display = "none";
  saveColorSelection(selectedVerseId, selectedColor);
  deselectVerse();
  colorPickerOpen = false;
}

function removeColor() {
  if (!isLoggedIn()) {
    $("#loginModal").modal("show");
    return;
  }

  let verseElement = document.querySelector(
    '[data-key="' + selectedVerseId + '"] .prose a'
  );
  if (verseElement) {
    verseElement.style.backgroundColor = "";

    let currentTheme = document.documentElement.getAttribute("data-theme");
    if (currentTheme === "dark") {
      verseElement.style.color = "#ffffff";
    }
  }
  document.getElementById("colorPickerModal").style.display = "none";
  document.getElementById("versePill").style.display = "none";
  saveColorSelection(selectedVerseId, "");
  deselectVerse();
  colorPickerOpen = false;
}

window.onclick = function (event) {
  let modal = document.getElementById("colorPickerModal");
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

function saveColorSelection(verseId, color) {
  $.ajax({
    url: "php/user_color/save_color.php",
    method: "POST",
    data: {
      verse_id: verseId,
      color: color,
    },
    success: function (response) {
      console.log("Color saved successfully.");
    },
  });
}

function closeColorPicker() {
  document.getElementById("colorPickerModal").style.display = "none";
  colorPickerOpen = false;
}

function showCommentModal(verseId) {
  selectedVerseId = verseId;
  let verseElement = document.querySelector(
    '[data-key="' + selectedVerseId + '"]'
  );
  let commentModal = document.getElementById("commentModal");

  if (commentModalOpen) {
    commentModal.style.display = "none";
    commentModalOpen = false;
  } else {
    if (verseElement) {
      let rect = verseElement.getBoundingClientRect();
      commentModal.style.display = "block";
      commentModal.style.left = `${rect.left + window.scrollX + 30}px`;
      commentModal.style.top = `${
        rect.top + window.scrollY + verseElement.offsetHeight
      }px`;
      commentModalOpen = true;

      fetchCommentForVerse(verseId);
    }
  }

  if (colorPickerOpen) {
    document.getElementById("colorPickerModal").style.display = "none";
    colorPickerOpen = false;
  }
}

function fetchCommentForVerse(verseId) {
  $.ajax({
    url: "php/user_comment/get_comment.php",
    method: "GET",
    data: {
      verse_id: verseId,
    },
    success: function (response) {
      try {
        let data = JSON.parse(response);
        if (data.comment) {
          document.getElementById("commentText").value = data.comment;
        } else {
          document.getElementById("commentText").value = "";
        }
      } catch (e) {
        console.error("Failed to parse response:", e);
        document.getElementById("commentText").value = "";
      }
    },
    error: function (xhr, status, error) {
      console.error("Error fetching comment: ", xhr.responseText);
      document.getElementById("commentText").value = "";
    },
  });
}

function removeComment() {
  if (!isLoggedIn()) {
    $("#loginModal").modal("show");
    return;
  }

  let verseElement = document.querySelector(
    '[data-key="' + selectedVerseId + '"] .prose'
  );

  if (verseElement) {
    verseElement.classList.remove("verse_has_user_comment");
  }

  $.ajax({
    url: "php/user_comment/remove_comment.php",
    method: "POST",
    data: {
      verse_id: selectedVerseId,
    },
    success: function (response) {
      console.log(response);
      document.getElementById("commentModal").style.display = "none";
      commentModalOpen = false;
      document.getElementById("versePill").style.display = "none";
      deselectVerse();
    },
    error: function (xhr, status, error) {
      console.error("Error removing comment: ", xhr.responseText);
      alert("An error occurred while removing the comment. Please try again.");
    },
  });
}

function saveComment() {
  if (!isLoggedIn()) {
    $("#loginModal").modal("show");
    return;
  }

  const comment = document.getElementById("commentText").value;
  const verseId = selectedVerseId;

  $.ajax({
    url: "php/user_comment/save_comment.php",
    method: "POST",
    data: {
      verse_id: verseId,
      comment: comment,
    },
    success: function (response) {
      console.log(response);

      document.getElementById("commentModal").style.display = "none";
      deselectVerse();
      commentModalOpen = false;
      document.getElementById("versePill").style.display = "none";

      let verseElement = document.querySelector(
        '[data-key="' + verseId + '"] .prose'
      );
      if (verseElement) {
        verseElement.classList.add("verse_has_user_comment");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error saving comment: ", xhr.responseText);
      alert("An error occurred while saving the comment. Please try again.");
    },
  });
}

function closeCommentModal() {
  document.getElementById("commentModal").style.display = "none";
  commentModalOpen = false;
}

window.onclick = function (event) {
  let colorPickerModal = document.getElementById("colorPickerModal");
  let commentModal = document.getElementById("commentModal");

  if (event.target == colorPickerModal) {
    closeColorPicker();
  } else if (event.target == commentModal) {
    closeCommentModal();
  }
};

function getUrlParameter(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
  var results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function updateMetaTag(name, content) {
  var metaTag =
    document.querySelector('meta[name="' + name + '"]') ||
    document.querySelector('meta[property="' + name + '"]') ||
    document.querySelector('link[rel="canonical"]');
  if (metaTag) {
    metaTag.setAttribute(name === "canonical" ? "href" : "content", content);
  } else {
    var newMetaTag = document.createElement(
      name === "canonical" ? "link" : "meta"
    );
    newMetaTag.setAttribute(
      name === "canonical" ? "rel" : "name",
      name === "canonical" ? "canonical" : name
    );
    newMetaTag.setAttribute(name === "canonical" ? "href" : "content", content);
    document.head.appendChild(newMetaTag);
  }
}

function updateLinkTag(rel, href) {
  var linkTag = document.querySelector('link[rel="' + rel + '"]');
  if (linkTag) {
    linkTag.setAttribute("href", href);
  } else {
    linkTag = document.createElement("link");
    linkTag.setAttribute("rel", rel);
    linkTag.setAttribute("href", href);
    document.getElementsByTagName("head")[0].appendChild(linkTag);
  }
}

function updateTitleFromUrl(tr, b, c) {
  if (tr && b && c) {
    var newTitle =
      getBookName(b) +
      " " +
      c +
      " | " +
      getTranslationMapping(tr) +
      " | Māceklis";
    document.title = newTitle;
    updateMetaTag("og:title", newTitle);
    updateMetaTag("og:url", window.location.href);
    updateMetaTag("og:site_name", window.location.host);
    updateLinkTag("canonical", window.location.href);
  }
}

$(document).ready(function () {
  var tr = getUrlParameter("tr");
  var bAbb = getUrlParameter("b");
  var c = getUrlParameter("c");
  var b = getBookIdByAbb(bAbb);
  updateTitleFromUrl(tr, b, c);
});

var myTimeout;
function scrollFunction() {
  clearTimeout(myTimeout);
  document.getElementById("verse_id_" + jump_to_v).scrollIntoView({
    behavior: "instant",
    duration: 0,
    block: "center",
    inline: "center",
  });
  jump_to_v = 1;
}

function loadInitURL() {
  var url = window.location.search;
  url = url.replace("?", "");
  var param = url.split("/");

  var tr = "lv65";
  var b = 43;
  var c = 1;
  var v = 1;

  if (param.length == 4) {
    b = getBookIdByAbb(param[1]);
    if (b > 0) {
      tr = param[0];
      c = param[2];
      v = param[3];
    } else {
      b = 1;
    }
  }

  current_tr = tr;
  current_c = c;
  current_b = b;
  jump_to_v = v;

  load_header(tr, b, c);
  load_c();
  load_all_on_init();
}

function getBookName(id) {
  return book_names[current_b - 1].s;
}

function getBookNameAbb(id) {
  return book_names[id - 1].abb;
}

function getBookIdByAbb(abb) {
  if (!book_names) {
    return -1;
  }
  var len = book_names.length;
  var i = 0;
  var id = -1;
  while (i < len - 1 && id < 0) {
    if (book_names[i].abb == abb) {
      id = i + 1;
    }
    i++;
  }
  return id;
}

function getTranslationMapping(tr) {
  const translation_map = {
    lv65: "RT65",
    lsb: "LSB",
    kjv: "KJV",
  };

  return translation_map[tr] || tr;
}

function updateMetaTag(name, content) {
  var meta = document.querySelector('meta[property="' + name + '"]');
  if (meta) {
    meta.setAttribute("content", content);
  } else {
    meta = document.createElement("meta");
    meta.setAttribute("property", name);
    meta.setAttribute("content", content);
    document.head.appendChild(meta);
  }
}

function updateLinkTag(name, content) {
  var link = document.querySelector('link[rel="' + name + '"]');
  if (link) {
    link.setAttribute("href", content);
  } else {
    link = document.createElement("link");
    link.setAttribute("rel", name);
    link.setAttribute("href", content);
    document.head.appendChild(link);
  }
}

function updateNavigation() {
  var currentBookIndex = current_b - 1;
  var currentBook = book_names[currentBookIndex];
  var totalChapters = Number(currentBook.c);

  var priorBookIndex = currentBookIndex;
  var priorChapter;

  if (current_c <= 1) {
    if (priorBookIndex <= 0) {
      priorBookIndex = book_names.length - 1;
    } else {
      priorBookIndex--;
    }
    priorChapter = book_names[priorBookIndex].c;
  } else {
    priorChapter = current_c - 1;
  }

  var nextBookIndex = currentBookIndex;
  var nextChapter;

  if (current_c >= totalChapters) {
    if (nextBookIndex >= book_names.length - 1) {
      nextBookIndex = 0;
    } else {
      nextBookIndex++;
    }
    nextChapter = 1;
  } else {
    nextChapter = Number(current_c) + 1;
  }

  var priorBook =
    priorBookIndex >= 0 && priorBookIndex < book_names.length
      ? book_names[priorBookIndex]
      : { s: "Unknown Book", c: 0 };
  var nextBook =
    nextBookIndex >= 0 && nextBookIndex < book_names.length
      ? book_names[nextBookIndex]
      : { s: "Unknown Book", c: 0 };

  $("#priorChapter, #priorChapterBottom").html(
    '<a type="button" class="py-0 px-0 border-0" style="text-decoration: none" onclick="onClickSetChapter(' +
      (priorBookIndex + 1) +
      "," +
      priorChapter +
      ')">' +
      "« " +
      priorBook.s +
      " " +
      priorChapter +
      "</a>"
  );

  $("#currentChapter, #currentChapterBottom").html(
    '<a type="button" style="font-weight: 650">' +
      currentBook.s +
      " " +
      current_c +
      "</a>"
  );

  $("#nextChapter, #nextChapterBottom").html(
    '<a type="button" class="py-0 px-0 border-0" style="text-decoration: none" onclick="onClickSetChapter(' +
      (nextBookIndex + 1) +
      "," +
      nextChapter +
      ')">' +
      nextBook.s +
      " " +
      nextChapter +
      " »" +
      "</a>"
  );
}

function load_c() {
  if (book_names && book_names[current_b - 1]) {
    $("#buttonBookSelectLabel").html(book_names[current_b - 1].s);
  }
  $("#offcanvasBottomLabel").html(book_names[current_b - 1].s);
  $("#comment_offcanvasBottomLabel").html(book_names[current_b - 1].s);
  $("#comment_buttonBookSelectLabel").html(book_names[current_b - 1].s);
  load_c_json(current_tr, current_b, current_c);
  updateNavigation();
}

function onChapter(b, c) {
  current_b = b;
  current_c = c;
  load_c();
}

function onClickSetChapter(b, c) {
  onChapter(b, c);
  $(".offcanvas").offcanvas("hide");
}

function prior_c() {
  var book = book_names[current_b - 1];

  if (current_c <= 1) {
    if (current_b <= 1) {
      current_b = book_names.length;
      current_c = book_names[current_b - 1].c;
    } else {
      current_b--;
      current_c = book_names[current_b - 1].c;
    }
  } else {
    current_c--;
  }
  load_c();
  updateNavigation();
}

function next_c() {
  var book = book_names[current_b - 1];

  if (current_c >= book.c) {
    if (current_b >= book_names.length) {
      current_b = 1;
      current_c = 1;
    } else {
      current_b++;
      current_c = 1;
    }
  } else {
    current_c++;
  }
  load_c();
  updateNavigation();
}

function load_bible_search_results(tr, search) {
  $("#div_bible_results").html("Notiek meklēšana...");

  var url = "php/search/bible_search.php?tr=" + tr + "&s=" + search;

  $.ajax({
    url: url,
    success: function (result) {
      o = JSON.parse(result);
      $("#div_bible_results").html("");

      if (o.rez == 1) {
        var comemnts = o.comemnts;
        var i = 0;
        while (i < comemnts.length) {
          var coment_id = comemnts[i].id;
          var coment_title = comemnts[i].title;
          var coment_html = comemnts[i].t;
          var b = comemnts[i].b;
          var c = comemnts[i].c;
          var v = comemnts[i].v;

          var html =
            '<div id="div_result_' +
            coment_id +
            '" <a type="button" onclick="results_onclick(' +
            b +
            "," +
            c +
            "," +
            v +
            ')" >' +
            '<div style="font-weight: bold; font-family: Linguistics Pro" >' +
            coment_title +
            "</div>" +
            '<div style="font-family: Linguistics Pro" class="mb-4-5">' +
            coment_html +
            "</div>" +
            "</a></div>";
          $("#div_bible_results").append(html);
          i++;
        }
      } else {
        $("#div_bible_results").html("Neizdevās atrast!");
      }
    },
    error: function (data) {
      alert("kluda");
    },
  });
}

function results_onclick(b, c, v) {
  selected_v = v;
  load_bcv(b, c, v);
}

function load_bcv(b, c, v) {
  jump_to_v = v;
  var current_c = c;
  var current_b = b;
  $("#offcanvasBottomLabel").html(book_names[b - 1].s);
  $("#comment_offcanvasBottomLabel").html(book_names[b - 1].s);
  $("#buttonBookSelectLabel").html(book_names[b - 1].s);
  $("#comment_buttonBookSelectLabel").html(book_names[b - 1].s);
  load_c_json(current_tr, b, c);
  load_header(current_tr, b, c);

  show_section_bible();
}

$("#input_search").on("keypress", function (event) {
  if (event.which == 13) {
    event.preventDefault();
    show_section_bible_results();
    tr = "lv65";
    var text = $("#input_search").val();
    if (text.length > 3) {
      load_bible_search_results(tr, text);
    } else {
      $("#div_bible_results").html("Lūdzu ieraksti meklējamo frāzi!");
    }
  }
});

$("#input_search").on("focus", function () {
  show_section_bible_results();
});

function load_c_json_coments(b, c) {
  var url = "php/comments/load_c_json_coments.php?b=" + b + "&c=" + c;

  $.ajax({
    url: url,
    success: function (result) {
      try {
        var o = JSON.parse(result);
        var chapter_html = "";

        if (o.varr && o.varr.length > 0) {
          coments_arr_set(b, c, o.varr);

          o.varr.forEach(function (comment) {
            var v = parseInt(comment.v);
            var v_to = parseInt(comment.v_to);

            for (var vi = v; vi <= v_to; vi++) {
              if (vi === v && vi === v_to) {
                $("#verse_id_" + vi).addClass("verse_has_coment_single");
              } else if (vi === v) {
                $("#verse_id_" + vi).addClass("verse_has_coment_start");
              } else if (vi === v_to) {
                $("#verse_id_" + vi).addClass("verse_has_coment_end");
              } else {
                $("#verse_id_" + vi).addClass("verse_has_coment_middle");
              }
              if (
                $("#verse_id_" + vi).hasClass(
                  "verse_has_coment_middle verse_has_coment_single"
                )
              ) {
                $("#verse_id_" + vi).removeClass("verse_has_coment_single");
                $("#verse_id_" + vi).addClass("verse_overlapping");
              }
            }
          });
        }
      } catch (e) {
        console.error("Failed to parse JSON response:", result);
        console.error("Error details:", e);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error during AJAX request:", status, error);
    },
  });
}

function coments_arr_set(b, c, varr) {
  coments_arr["b_" + b + "_c_" + c] = varr;
}

function coments_arr_get(b, c) {
  if (coments_arr.hasOwnProperty("b_" + b + "_c_" + c)) {
    return coments_arr["b_" + b + "_c_" + c];
  } else return null;
}

function hasComment(b, c, v) {
  var varr = coments_arr_get(b, c);
  if (varr === null) return false;

  return varr.some(function (comment) {
    var v_v = comment.v;
    var v_v_to = comment.v_to;
    if (v_v_to === 0) {
      v_v_to = v_v;
    }
    return v_v <= v && v <= v_v_to;
  });
}

function show_offcanvas_comment(b, c, v) {
  var varr = coments_arr_get(b, c);
  var html = "";
  var title = "";

  if (varr !== null) {
    var i = 0;
    while (i < varr.length) {
      var v_v = varr[i].v;
      var v_v_to = varr[i].v_to;
      if (v_v_to === 0) {
        v_v_to = v_v;
      }
      var v_html = varr[i].html;

      if (v_v <= v && v <= v_v_to) {
        html = v_html;
        title = varr[i].title;
        break;
      }

      i++;
    }
  }

  if (html !== "") {
    $("#offcanvasCommentLabel").html(title);
    $("#offcanvasCommentText").html(html);
    $("#sidebar_bottom").offcanvas("show");
  } else {
    if ($("#sidebar_bottom").hasClass("show")) {
      $("#sidebar_bottom").offcanvas("hide");
    }
  }
}

function changeFontSize(size) {
  var fontSizes = {
    small: "13pt",
    medium: "15pt",
    large: "17pt",
  };

  $("p a, span a, label a").css("font-size", fontSizes[size]);

  $("small span").css("font-size", parseInt(fontSizes[size]) * 0.8 + "pt");
}

function load_user_comments(book, chapter) {
  if (!isLoggedIn()) {
    return;
  }

  var url =
    "php/user_comments/load_c_json_user_comments.php?book=" +
    book +
    "&chapter=" +
    chapter;
  $.ajax({
    url: url,
    dataType: "json",
    success: function (data) {
      if (data.error) {
        console.error(data.error);
        return;
      }

      var versesWithComments = data.verses_with_comments;

      versesWithComments.forEach(function (verseId) {
        var verseElement = document.querySelector(
          '[data-key="' + verseId + '"]'
        );

        if (verseElement) {
          var parentDiv = verseElement.closest('div[id^="verse_id_"]');

          if (parentDiv) {
            var proseSpan = parentDiv.querySelector("span.prose");

            if (proseSpan) {
              proseSpan.classList.add("verse_has_user_comment");
            }
          }
        }
      });
    },
    error: function (xhr, status, error) {},
  });
}

var user_comments_arr = {};

function user_comments_arr_set(b, c, varr) {
  user_comments_arr["b_" + b + "_c_" + c] = varr;
}

function user_comments_arr_get(b, c) {
  if (user_comments_arr.hasOwnProperty("b_" + b + "_c_" + c)) {
    return user_comments_arr["b_" + b + "_c_" + c];
  } else {
    return null;
  }
}

function hasUserComment(b, c, v) {
  var varr = user_comments_arr_get(b, c);
  if (varr === null) return false;

  return varr.some(function (comment) {
    var v_v = comment.v;
    var v_v_to = comment.v_to;
    if (v_v_to === 0) {
      v_v_to = v_v;
    }
    return v_v <= v && v <= v_v_to;
  });
}
