<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Māceklis | Studē Bībeli</title>
    <meta name="keywords" content="Bībele, Jēzus, Kristus, Māceklis, Mācīties, Studēt, Study Bible, Draudze, Baznīca" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nāc, redzi un piedzīvo to savā dzīvē. Dievs dara savu pārveidojošo darbu.">
    <meta property="og:description" content="Nāc, redzi un piedzīvo to savā dzīvē. Dievs dara savu pārveidojošo darbu.">
    <meta property="og:title" content="Māceklis | Studē Bībeli">
    <meta property="og:url" content="http://maceklis.lv/">
    <meta property="og:site_name" content="SiteName">
    <meta property="og:image" content="http://maceklis.lv/img/maceklis_logo.png" />
    <link rel="canonical" href="http://maceklis.lv/" />
    <meta name="twitter:title" content="Māceklis | Studē Bībeli">
    <meta name="twitter:description"
        content="Nāc, redzi un piedzīvo to savā dzīvē. Dievs dara savu pārveidojošo darbu.">
    <meta name="twitter:image" content="http://maceklis.lv/img/maceklis_logo.png">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/flickity.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/theme.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/usedicons.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/theme-2.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="img/maceklis_logo.ico" type="image/jpg" rel="shortcut icon" />
    <link href="editor/summernote-0.8.18-dist/summernote-lite.css" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">

    <style type="text/css">
    .a_option_hidden {
        display: none;
    }
    </style>
    <script>
    function isLoggedIn() {
        return <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    }
    </script>


</head>

<body class="bg--lightbrown verse-by-verse verse-numbers section-heading" data-theme="light">
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <!-- close sidebar menu -->
            <div class="dismiss">
                <i class="fas fa-arrow-right"></i>
            </div>

            <div class="logo">
                <h3><a>Sidebar Menu</a></h3>
            </div>
            <!-- Sidebar menu elements -->
            <ul class="list-unstyled menu-elements">
                <li>
                    <div class="col-auto ms-auto me-1">
                        <h4 class="mb-2 mt-2 banner">
                            <a class="scroll-link" href="#" onclick="show_section_bible()"
                                style="{color:black} :hover {color: white}">
                                <i class="fas fa-book-bible"></i>
                                <span class="tr_bible">Bībele</span>
                            </a>
                        </h4>
                    </div>
                </li>

                <li>
                    <div class="col-auto ms-1 me-1">
                        <h4 class="mb-2 mt-2 banner">
                            <a class="scroll-link" href="#" onclick="show_section_comments()"
                                style="{color:black} :hover {color: white}">
                                <i class="fas fa-comment"></i>
                                <span class="tr_comments">Komentāri</span>
                            </a>
                        </h4>
                    </div>
                </li>

                <li>
                    <div class="col-auto ms-1 me-1">
                        <h4 class="mb-2 mt-2 banner">
                            <a class="scroll-link" href="#" onclick="show_section_dictionary()"
                                style="{color:black} :hover {color: white}">
                                <i class="fas fa-book"></i>
                                Vārdnīca
                            </a>
                        </h4>
                    </div>
                </li>

                <li>
                    <div class="col-auto ms-1 me-1">
                        <h4 class="mb-2 mt-2 banner">
                            <a href="#" style="color:#5c4f3159; pointer-events: none;">
                                <i class="fas fa-link"></i>
                                Mācekļošanas resursi
                            </a>
                        </h4>
                    </div>
                </li>

                <li>
                    <div class="col-auto ms-1 me-1">
                        <h4 class="mb-2 mt-2 banner">
                            <a href="#" style="color:#5c4f3159; pointer-events: none;">
                                <i class="fas fa-circle-info"></i>
                                Aktuālās tēmas
                            </a>
                        </h4>
                    </div>
                </li>

                <li>
                    <div class="col-auto ms-1 me-1">
                        <h4 class="mb-2 mt-2 banner">
                            <a href="#" style="color:#5c4f3159; pointer-events: none;">
                                <i class="fas fa-question"></i>
                                Jautājumi
                            </a>
                        </h4>
                    </div>
                </li>

                <li class="a_option a_option_hidden">
                    <div class="col-auto ms-1 me-1">
                        <h4 class="mb-2 mt-2 banner">
                            <a href="#" onclick="show_section_comments_editor()"
                                style="{color:black} :hover {color: white}">+</a>
                        </h4>
                    </div>
                </li>
            </ul>
            <!-- End of Sidebar elements -->
        </nav>
        <!-- End sidebar -->



        <!-- Content -->
        <div class="content">
            <!-- Top Navigation -->
            <!--<a class="btn btn-primary btn-customized open-menu" id="sidebarbtn" role="button">
            		<i class="fas fa-arrow-left"></i>
        		</a>-->

            <div class="row side-margin side-margin-mobile no-gutters d-flex align-items-end mt-3">
                <!-- Left-aligned elements -->
                <div class="col-auto">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto" onclick="show_section_bible()">
                            <img alt="logo" class="img-fluid" src="img/maceklis_logo.png" width="50" />
                        </div>

                        <!-- Combined icon for small screens -->
                        <div class="col-auto mt-3 d-inline-block d-sm-none">
                            <a class="px-2 py-2 btn-top" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-list"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="mb-2"><a class="dropdown-item" style="justify-content: left; font-size: 16px"
                                        href="#" onclick="show_section_bible()"><i
                                            class="me-2 fas fa-book-bible"></i>Bībele</a></li>
                                <li class="my-2"><a class="dropdown-item" style="justify-content: left; font-size: 16px"
                                        href="#" onclick="show_section_comments()"><i
                                            class="me-2 fas fa-comment"></i>Komentāri</a></li>
                                <li class="my-2"><a class="dropdown-item" style="justify-content: left; font-size: 16px"
                                        href="#" onclick="show_section_dictionary()"><i
                                            class="me-2 fas fa-book"></i>Vārdnīca</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="dropdown-submenu my-2">
                                    <a class="dropdown-item" style="justify-content: left; font-size: 16px" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="me-2 fas fa-user"></i> Lietotājs
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if (isset($_SESSION['username']) && isset($_SESSION['user_id'])): ?>
                                        <li class="dropdown-item">
                                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                                        </li>
                                        <li><a class="dropdown-item" href="log-in/logout.php">Izrakstīties</a></li>
                                        <?php else: ?>
                                        <li><a class="dropdown-item" href="log-in/login.html">Pierakstīties</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu my-2">
                                    <a class="dropdown-item" style="justify-content: left; font-size: 16px" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="me-2 fas fa-gear"></i> Iestatījumi
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu" style="font-size: 15px; font-size: 15px">
                                            <a class="dropdown-item" href="#">Bībeles tulkojums <span
                                                    style="margin-left: auto; white-space: nowrap;">&nbsp > </span></a>
                                            <ul class="dropdown-menu submenu" style="left: 100%">
                                                <li><a class="dropdown-item" onclick="set_tr('lv65')">LV1965 Rev</a>
                                                </li>
                                                <li><a class="dropdown-item" onclick="set_tr('lsb')">LSB</a></li>
                                                <li><a class="dropdown-item" onclick="set_tr('kjv')">KJV</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu" style="font-size: 15px">
                                            <a class="dropdown-item" href="#">Mainīt motīvu<span
                                                    style="margin-left: auto; white-space: nowrap;"> > </span></a>
                                            <ul class="dropdown-menu submenu" style="left: 100%; font-size: 15px">
                                                <li><a class="dropdown-item" id="lightThemeSmall">Gaišs</a></li>
                                                <li><a class="dropdown-item" id="darkThemeSmall">Tumšs</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu" style="font-size: 15px">
                                            <a class="dropdown-item" href="#">Burtu lielums<span
                                                    style="margin-left: auto; white-space: nowrap;"> &nbsp> </span></a>
                                            <ul class="dropdown-menu submenu" style="left: 100%; font-size: 15px">
                                                <li><a class="dropdown-item" onclick="changeFontSize('small')">Mazs</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        onclick="changeFontSize('medium')">Vidējs</a></li>
                                                <li><a class="dropdown-item" onclick="changeFontSize('large')">Liels</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <!-- Individual icons for larger screens -->
                        <div class="col-auto ms-1 me-1 neradit-mob neradit-1 hide-buttons mobile-logo-margin">
                            <h4 class="banner" style="margin-bottom: 0; margin-top: 10px">
                                <a class="hide-element" href="#" onclick="show_section_bible()">
                                    <i class="fas fa-book-bible"></i>
                                    <span class="neradit-label">
                                        <span class="tr_bible">Bībele</span>
                                    </span>
                                </a>
                            </h4>
                        </div>

                        <div class="col-auto ms-1 me-1 neradit-mob neradit-1 hide-buttons mobile-logo-margin">
                            <h4 class="banner" style="margin-bottom: 0; margin-top: 10px">
                                <a class="hide-element" href="#" onclick="show_section_comments()">
                                    <i class="fas fa-comment"></i>
                                    <span class="neradit-label">
                                        <span class="tr_comments">Komentāri</span>
                                    </span>
                                </a>
                            </h4>
                        </div>

                        <div class="col-auto ms-1 neradit-mob neradit-1 hide-buttons mobile-logo-margin">
                            <h4 class="banner" style="margin-bottom: 0; margin-top: 10px">
                                <a class="hide-element" href="#" onclick="show_section_dictionary()">
                                    <i class="fas fa-book"></i>
                                    <span class="neradit-label">Vārdnīca</span>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Right-aligned elements -->
                <div class="col-auto ms-auto">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto neradit-mob hide-buttons dropdown">
                            <h4 class="banner" style="margin-bottom: 0; margin-top: 10px">
                                <a class="hide-element me-2" style="text-decoration: none" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                </a>
                                <ul class="dropdown-menu" id="userMenu">
                                    <?php if (isset($_SESSION['username']) && isset($_SESSION['user_id'])): ?>
                                    <li class="dropdown-item">
                                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                                    </li>
                                    <li><a class="dropdown-item" href="log-in/logout.php">Izrakstīties</a></li>
                                    <?php else: ?>
                                    <li><a class="dropdown-item" href="log-in/login.html">Pierakstīties</a></li>
                                    <?php endif; ?>
                                </ul>

                                <a class="hide-element" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-gear"></i>
                                </a>
                                <ul class="dropdown-menu custom-dropdown" id="mainMenu">
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#">Bībeles tulkojums <span
                                                style="margin-left: auto; white-space: nowrap;">&nbsp > </span></a>
                                        <ul class="dropdown-menu submenu">
                                            <li>
                                                <a class="dropdown-item" onclick="set_tr('lv65')">LV1965 Rev</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" onclick="set_tr('lsb')">LSB</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" onclick="set_tr('kjv')">KJV</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#">Mainīt motīvu<span
                                                style="margin-left: auto; white-space: nowrap;"> > </span></a>
                                        <ul class="dropdown-menu submenu">
                                            <li>
                                                <a class="dropdown-item" id="lightTheme">Gaišs</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="darkTheme">Tumšs</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#">Burtu lielums<span
                                                style="margin-left: auto; white-space: nowrap;"> &nbsp> </span></a>
                                        <ul class="dropdown-menu submenu">
                                            <li>
                                                <a class="dropdown-item" onclick="changeFontSize('small')">Mazs</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" onclick="changeFontSize('medium')">Vidējs</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" onclick="changeFontSize('large')">Liels</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </h4>
                        </div>

                        <div class="col class_input_search mt-2" style="padding: 0;">
                            <input id="input_search" class="form-control py-2 rounded-pill border border-gray w-100"
                                style="margin: 0; max-width: 180px;" type="text" name="input_search"
                                placeholder="meklēt..." />
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Top Navigation -->

            <!-- Element sections -->
            <div id="div_sections">
                <!-- Comment Editor -->
                <section id="section_comments_editor"
                    class="main_section_selector mx-0 mx-md-5 bg--white rounded border border-gray"
                    style="display: none; min-height: 100vh; margin: 0px; padding: 0px; ">

                    <div style=" margin: 0px; height: 100vh; ">
                        <iframe id="iframe_comments_editor" src="/editor/?id=0"
                            style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"
                            title="Iframe Example">
                        </iframe>
                    </div>
                </section>
                <!-- End Comment Editor -->

                <!-- Bible Comentary Section -->
                <section id="section_comments"
                    class="main_section_selector custom-margin bg--white rounded border border-gray"
                    style="display: none; min-height: 100vh; ">
                    <div class="Passage__PassageContainer-sc-1drf6wh-1 crkUpe text-center">
                        <h1 class="Passage__StyledPassageTitle-sc-1drf6wh-0 eUlFsT book-title-font mb-2">Bībeles
                            komentāri
                        </h1>
                    </div>

                    <div class="dropdown">
                        <button class="btn px-3 dropdown-toggle mb-1 button-text-color" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"
                            style="border-radius: 10px;">
                            Izvēlies grāmatu
                        </button>
                        <ul id="comment_book_names" class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                            style="overflow-y: auto; max-height: 200px;">
                        </ul>
                    </div>
                    <p class="comment-top-line"></p>
                    <div id="div_comments">
                        <div id="div_comment_1">
                            <div>
                                Virsraksts
                            </div>
                            <div>
                                Teksts
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End Bible Commentary Section -->

                <!-- Bibele Dictionary Section -->
                <section id="section_dictionary"
                    class="main_section_selector custom-margin bg--white rounded border border-gray"
                    style="display: none; min-height: 100vh; ">
                    <div class="Passage__PassageContainer-sc-1drf6wh-1 crkUpe text-center">
                        <h1 class="Passage__StyledPassageTitle-sc-1drf6wh-0 eUlFsT book-title-font mb-5">Bībeles
                            vārdnīca
                        </h1>
                    </div>

                    <p class="comment-top-line"></p>
                    <div id="div_dictionary"></div>
                </section>
                <!-- End Bibele Dictionary Section -->

                <!-- Search Bar Section -->
                <section id="section_bible_results"
                    class="main_section_selector custom-margin bg--white rounded border border-gray"
                    style="display: none; min-height: 100vh; ">
                    <div class="Passage__PassageContainer-sc-1drf6wh-1 crkUpe text-center">
                        <h1 class="Passage__StyledPassageTitle-sc-1drf6wh-0 eUlFsT book-title-font mb-5">Meklēšana
                        </h1>
                    </div>

                    <p class="comment-top-line"></p>

                    <div id="div_bible_results">
                        <div id="div_comment_1">
                            <div>
                                Lūdzu ieraksti meklējamo frāzi!
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </section>
                <!-- End Search Bar Section -->

                <!-- Bible Section -->
                <section id="section_bible"
                    class="main_section_selector custom-margin bg--white rounded border border-gray"
                    style="min-height: 100vh;">
                    <div class="Passage__PassageContainer-sc-1drf6wh-1 crkUpe text-center">
                        <h1 class="Passage__StyledPassageTitle-sc-1drf6wh-0 eUlFsT">
                            <a type="button" aria-controls="sidebar_bottom" data-bs-toggle="offcanvas"
                                data-bs-target="#sidebar_book">
                                <span id="buttonBookSelectLabel" class="book-title-font"></span>
                            </a>
                            <div class="navigation-chapters kWZCIu">
                                <span id="priorChapter" class="chapter-link pill"></span>
                                <span class="ms-1 me-2"> | </span>
                                <span id="currentChapter" class="chapter-link current-pill"></span>
                                <span class="ms-2 me-1"> | </span>
                                <span id="nextChapter" class="chapter-link pill"></span>
                            </div>
                        </h1>

                        <!--Book Selection Offcanvas -->
                        <div class="offcanvas offcanvas-bottom text-center" data-bs-backdrop="false" tabindex="-999"
                            id="sidebar_book" aria-labelledby="offcanvasBottomLabel"
                            style="--bs-offcanvas-height: 100vh; transition: all 0.2s;">
                            <div class="row bg-canvastop justify-content-center">
                                <div class="col-auto offcanvas-header">
                                    <a type="button">
                                        <h2 class="offcanvas-title ms-4" id="offcanvasBottomLabel">
                                            1. Mozus
                                        </h2>
                                    </a>
                                    <a type="button" id="topbookBtn">
                                        <i class="px-2 pt-3 fas fa-caret-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row bg-canvasbody border-bottom shadow">
                                <div class="offcanvas-body col-6">
                                    <a type="button" id="OldTestament" onclick="onclickOTbutton()">
                                        <h3 class="mt-0 mb-2 hover-underline-animation"> Vecā Derība</h3>
                                    </a>
                                </div>
                                <div class="offcanvas-body col-6">
                                    <a type="button" id="NewTestament" onclick="onclickNTbutton()">
                                        <h3 class="mt-0 mb-2 hover-underline-animation"> Jaunā Derība</h3>
                                    </a>
                                </div>
                            </div>

                            <!-- Outputs books and chapters -->
                            <div class="offcanvas-body small bg-canvasbooks" id="book_names_list">
                            </div>

                        </div>
                        <!-- End Book Selection Offcanvas -->
                    </div>

                    <!-- Comment offcanvas -->
                    <div class="offcanvas offcanvas-bottom" data-bs-scroll="true" data-bs-backdrop="false"
                        tabindex="-999" id="sidebar_bottom" aria-labelledby="offcanvasBottomLabel">
                        <div class="offcanvas-header align-items-center bg-canvastop">
                            <h2 class="offcanvas-title ms-4" id="offcanvasCommentLabel" style="margin-right: 30px;">
                                Attiecīgā rakstvieta</h2>
                            <button type="button" class="offcanvas-modal-btn-left"
                                onclick="showColorPicker(selectedVerseId)">Iekrāsot pantu</button>
                            <button type="button" class="offcanvas-modal-btn-right"
                                onclick="showCommentModal(selectedVerseId)">Komentēt pantu</button>
                            <button type="button" class="btn-close px-4 py-4" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body small bg-canvasbody"
                            style="overscroll-behavior: contain; overflow-y: scroll;">
                            <h3 class="offcanvas-title mt-3" id="offcanvasCommentText" style="margin: 20px;">Komentārs
                                par rakstvietu.</h3>
                        </div>
                    </div>


                    <!-- End Comment offcanvas -->
                    <div class="passage" id="chapter_content"></div>

                    <div id="versePill" class="verse-pill" style="display: none;">
                        <button class="pill-btn-left" onclick="showColorPicker(selectedVerseId)">Iekrāsot pantu</button>
                        <button class="pill-btn-right" onclick="showCommentModal(selectedVerseId)">Komentēt
                            pantu</button>
                    </div>

                    <div id="colorPickerModal" class="color-modal">
                        <div class="color-modal-content">
                            <button class="close-button" onclick="closeColorPicker()">&times;</button>
                            <h5 style="margin-bottom: 0; text-align: center">Izvēlies krāsu</h5>
                            <hr class="mt-1 mb-3 color-modal-hr">
                            <div class="color-options">
                                <button class="color-option" style="background-color: #e4dd11;"
                                    onclick="selectColor('#e4dd11')"></button>
                                <button class="color-option" style="background-color: #e41111;"
                                    onclick="selectColor('#e41111')"></button>
                                <button class="color-option" style="background-color: #e411d2;"
                                    onclick="selectColor('#e411d2')"></button>
                                <button class="color-option" style="background-color: #19cc58;"
                                    onclick="selectColor('#19cc58')"></button>
                                <button class="color-option" style="background-color: #006eff;"
                                    onclick="selectColor('#006eff')"></button>
                                <button class="color-option" style="background-color: #11c1e4;"
                                    onclick="selectColor('#11c1e4')"></button>
                            </div>
                            <div class="button-container">
                                <!--<button class="color-modal-btn" onclick="applyColor()">Apply</button>-->
                                <button class="color-modal-btn" onclick="removeColor()">Noņemt</button>
                            </div>
                        </div>
                    </div>

                    <div id="commentModal" class="color-modal">
                        <div class="color-modal-content">
                            <button class="close-button" onclick="closeCommentModal()">&times;</button>
                            <h5 style="margin-bottom: 0; text-align: center">Ieraksti komentāru</h5>
                            <hr class="mt-1 mb-3 color-modal-hr">
                            <textarea id="commentText" class="form-control" rows="4"></textarea>
                            <div class="button-container">
                                <button class="color-modal-btn-left" onclick="saveComment()">Saglabāt</button>
                                <button class="color-modal-btn-right" onclick="removeComment()">Noņemt</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Structure -->
                    <div class="modal fade" id="loginModal" tabindex="1" aria-labelledby="loginModalLabel"
                        aria-hidden="true" data-bs-backdrop="false"
                        style="--bs-modal-width: 350px; background: rgba(0, 0, 0, 0.5);">
                        <div class="modal-dialog"
                            style="position: absolute; top: 50%; left: 48%; transform: translate(-50%, -50%); width: 350px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" style="margin-bottom:0" id="loginModalLabel">Nepieciešama
                                        pierakstīšanās</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p style="font-size: 13pt">Lūdzu, pierakstieties pirms veicat darbības!</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="login-modal-btn"
                                        onclick="location.href='log-in/login.html'">Pierakstīties</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="Passage__PassageContainer-sc-1drf6wh-1 crkUpe text-center mt-4">
                        <h1 class="Passage__StyledPassageTitle-sc-1drf6wh-0 eUlFsT">
                            <div class="navigation-chapters kWZCIu">
                                <span id="priorChapter" class="chapter-link pill"></span>
                                <span class="ms-1 me-2"> | </span>
                                <span id="currentChapter" class="chapter-link current-pill"></span>
                                <span class="ms-2 me-1"> | </span>
                                <span id="nextChapter" class="chapter-link pill"></span>
                            </div>
                        </h1>
                    </div>

                </section>
                <!-- End Bible Section -->
            </div>
            <!-- End Element Sections -->
        </div>
        <!-- End content -->
    </div>
    <!-- End wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/static/jquery.steps.min.js"></script>
    <script src="js/static/flickity.min.js"></script>
    <script src="js/static/bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
    <script src="js/static/typed.min.js"></script>
    <script src="js/static/smooth-scroll.min.js"></script>
    <script src="js/static/scripts.js?1"></script>
    <script src="js/static/wow.js"></script>
    <script src="js/get_settings.js?1"></script>
    <script src="js/load_bible_json.js?16"></script>
    <script src="js/bible_comments.js?13"></script>
    <script src="js/translations.js?2"></script>
    <script src="editor/summernote-0.8.18-dist/summernote-lite.js"></script>

    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const submenus = document.querySelectorAll('.dropdown-submenu > a');

        submenus.forEach(submenu => {
            submenu.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                const submenuContent = submenu.nextElementSibling;
                if (submenuContent && submenuContent.classList.contains('submenu')) {
                    submenuContent.classList.toggle('show');
                }
            });
        });
    });


    /* Set theme of the page */
    function setTheme(theme) {
        document.body.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
    }

    // Event listeners for theme selection
    document.getElementById('lightTheme').addEventListener('click', function() {
        setTheme('light');
    });

    document.getElementById('darkTheme').addEventListener('click', function() {
        setTheme('dark');
    });

    document.getElementById('lightThemeSmall').addEventListener('click', function() {
        setTheme('light');
    });

    document.getElementById('darkThemeSmall').addEventListener('click', function() {
        setTheme('dark');
    });

    // Apply the saved theme on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            setTheme(savedTheme);
        } else {
            setTheme('light'); // default to light if no theme is saved
        }
    });

    //
    document.addEventListener('DOMContentLoaded', function() {
        var submenus = document.querySelectorAll('.dropdown-submenu');

        submenus.forEach(function(submenu) {
            submenu.addEventListener('mouseenter', function(event) {
                event.stopPropagation();
                submenu.querySelector('.submenu').classList.add('show');
            });

            submenu.addEventListener('mouseleave', function(event) {
                event.stopPropagation();
                submenu.querySelector('.submenu').classList.remove('show');
            });
        });
    });


    function changeDropdownText(selectedElement) {
        document.getElementById('dropdownMenuButton').textContent = selectedElement;
    }

    function scroll_to(clicked_link, nav_height) {
        var element_class = clicked_link.attr('href').replace('#', '.');
        var scroll_to = 0;
        if (element_class != '.top-content') {
            element_class += '-container';
            scroll_to = $(element_class).offset().top - nav_height;
        }
        if ($(window).scrollTop() != scroll_to) {
            $('html, body').stop().animate({
                scrollTop: scroll_to
            }, 1000);
        }
    }

    jQuery(document).ready(function() {
        /*Sidebar*/

        $('.hover-underline-animation').on('click', function() {
            $('.hover-underline-animation').not(this).removeClass(
                '.hover-underline-animation-underline');
            $(this).toggleClass('.hover-underline-animation-underline');
        });

        $(document).on("click", "#offcanvasBottomLabel", function() {
            $('.offcanvas').offcanvas('hide');
        });

        $(document).on("click", "#comment_offcanvasBottomLabel", function() {
            $('.offcanvas').offcanvas('hide');
        });

        $('.scroll-link').on('click', function() {
            $('.sidebar').removeClass('active');
        });

        $(document).on("click", "#bookSelect", function() {
            $(this).toggleClass("hr-lines-after");
        });

        $(document).on("click", "#topbookBtn", function() {
            $('.offcanvas').offcanvas('hide');
        });

        $('.btn').on('click', function() {
            $('.sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('.passage').on('click', function() {
            $('.sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('.dismiss, .overlay').on('click', function() {
            $('.sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('.open-menu').on('click', function(e) {
            e.preventDefault();
            $('.sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.offcanvas').offcanvas('hide');
            // close opened sub-menus
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

        /* change sidebar style */
        $('a.btn-customized-dark').on('click', function(e) {
            e.preventDefault();
            $('.sidebar').removeClass('light');
        });

        $('a.btn-customized-light').on('click', function(e) {
            e.preventDefault();
            $('.sidebar').addClass('light');
        });

        /*Navigation*/
        $('a.scroll-link').on('click', function(e) {
            e.preventDefault();
            scroll_to($(this), 0);
        });

        $('.to-top a').on('click', function(e) {
            e.preventDefault();
            if ($(window).scrollTop() != 0) {
                $('html, body').stop().animate({
                    scrollTop: 0
                }, 1000);
            }
        });

        new WOW().init();
    });
    </script>
</body>

</html>