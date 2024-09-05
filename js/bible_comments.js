function show_section(section_id) {
  load_settings("");
  $(".main_section_selector").hide();
  $("#" + section_id).show();
}

const state = {
  bibleCommentsLoaded: false,
  dictionaryLoaded: false,
};

function show_section_comments() {
  show_section("section_comments");
  if (!state.bibleCommentsLoaded) {
    state.bibleCommentsLoaded = true;
    load_comment_books(current_tr);
  }
}

function show_section_dictionary() {
  show_section("section_dictionary");
  if (!state.dictionaryLoaded) {
    state.dictionaryLoaded = true;
    load_dictionary(0);
  }
}

function load_all_on_init() {
  if (!state.bibleCommentsLoaded) {
    state.bibleCommentsLoaded = true;
    load_comment_books(current_tr);
  }
  if (!state.dictionaryLoaded) {
    state.dictionaryLoaded = true;
    load_dictionary(0);
  }
}

function open_edit(id, type) {
  const urlMap = {
    comment: "/editor/?id=",
    dictionary: "/editor/dictionary.php?id=",
  };
  window.open(urlMap[type] + id);
}

// Optimized HTML builder for comments and dictionary entries
function buildAccordionHtml(id, title, htmlContent, editCallback) {
  return `
    <div class="vertical-hr accordion accordion-flush accordion-bg">
      <div class="accordion-item">
        <div class="accordion-header">
          <div class="row">
            <div class="col-10">
              <div type="button" class="entry-title" onclick="showDescription(${id})">${title}</div>
            </div>
            <div class="col-2 text-end ${ao_class()}">
              <a type="button" style="color: #D3D3D3;" onclick="${editCallback}">Labot</a>
            </div>
          </div>
        </div>
        <div class="entry-description" id="description_${id}">${htmlContent}</div>
      </div>
    </div>`;
}

function load_bible_comments(b) {
  const ofset = 0;
  const $divComments = $("#div_comments");
  $divComments.html("Notiek ielāde...").empty();

  const url = `php/comments/load_bible_comments.php?ofset=${ofset}&b=${b}`;

  $.ajax({
    url: url,
    success: function (result) {
      const o = JSON.parse(result);
      if (o.rez === 1) {
        const comments = o.comemnts;
        const commentsHtml = comments
          .map((comment) =>
            buildAccordionHtml(
              comment.id,
              comment.title,
              comment.html,
              `open_edit(${comment.id}, 'comment')`
            )
          )
          .join("");
        $divComments.append(commentsHtml);
      }
    },
  });
}

function load_dictionary(ofset) {
  const $divDictionary = $("#div_dictionary");
  $divDictionary.html("Notiek ielāde...");

  const url = `php/dictionary/load_dictionary.php?ofset=${ofset}`;

  $.ajax({
    url: url,
    success: function (result) {
      const o = JSON.parse(result);
      if (o.rez === 1) {
        const dictionaryHtml = o.dictionary
          .map((entry) =>
            buildAccordionHtml(
              entry.id,
              entry.word,
              entry.html,
              `open_edit(${entry.id}, 'dictionary')`
            )
          )
          .join("");
        $divDictionary.html(dictionaryHtml);
      }
    },
  });
}

function showDescription(tag_id) {
  $(`#description_${tag_id}`).toggle();
}

function load_comment_books(tr) {
  $("#div_comments").html("Lūdzu izvēlies nodaļu!");
  const url = "php/comments/load_comment_books.php?tr=lv";

  $.ajax({
    url: url,
    success: function (result) {
      const o = JSON.parse(result);
      let html = `<li><a class="dropdown-item" href="#" onclick="changeDropdownText('Jaunākie'); load_bible_comments(0);">Jaunākie</a></li>`;

      if (o.length > 0) {
        html += o
          .map((book) => {
            const cc_html = book.count > 0 ? `(${book.count})` : "";
            return `<li><a class="dropdown-item" href="#" onclick="changeDropdownText('${book.a}${cc_html}'); load_bible_comments(${book.i});">${book.a}${cc_html}</a></li>`;
          })
          .join("");
      }

      $("#comment_book_names").html(html);
      load_bible_comments(0);
    },
  });
}
