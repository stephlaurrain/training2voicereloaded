<?php include ("./init.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <link href="./includes/front/bootstrap-4.1.3-dist/css/bootstrap.min.css" rel="stylesheet">                
        <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <link href="./webappli/public/css/style.css" rel="stylesheet" />
        <link href="./includes/front/jsgrid-1.5.3/jsgrid.min.css" rel="stylesheet" type="text/css"/>
        <link href="./includes/front/jsgrid-1.5.3/jsgrid-theme.min.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <title>Training2Voice</title>



    </head>
    <body>
        <header>

        </header>
        <div class="main">    
            <div id="debug" style="visibility: hidden;">debug</div>
            <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                <!-- Brand -->
                <a class="navbar-brand trn-bar" href="index.php"><span class="logo fas fa-dumbbell"></span><span  class="title">Training2Voice</span></a>

                <!-- Links -->
                <ul class="navbar-nav">                    
                    <li class="nav-item">
                        <div class="toolbar-btn-container">
                            <input id="tb-add" class="toolbar-button toolbar-add-button" type="button" title="add">
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="toolbar-btn-container">
                            <input id="tb-play" class="toolbar-button toolbar-play-button" type="button" title="play">
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="toolbar-btn-container">
                            <input id="tb-duplicate" class="toolbar-button toolbar-duplicate-button" type="button" title="duplicate">
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="toolbar-btn-container">
                            <input id="tb-coherence" class="toolbar-button toolbar-coherence-button" type="button" title="coherence">
                        </div>
                    </li>
                    <!-- Dropdown -->    
                    <li class="nav-item dropdown">
                        <a class="nav-item" href="#" id="navbardrop" data-toggle="dropdown">
                            <div class="toolbar-btn-container">
                                <input id="tb-settings" class="toolbar-button toolbar-settings-button" type="button" title="settings">
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <!-- <a class="dropdown-item" href="#">Link 1</a>
                             <a class="dropdown-item" href="#">Link 2</a> -->
                            <a class="dropdown-item" href="phrase.php">Phrases</a>
                            <a class="dropdown-item" href="param.php">Paramètres</a>
                        </div>
                    </li>                    
                </ul>
            </nav>