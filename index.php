<?php
    session_start();
    ob_start();
    require_once __DIR__ . '/lib/config.php';
?>
<!DOCTYPE html>
  <html lang="da">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <!--Import Google Icon Font-->
      <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
      <link rel="stylesheet" href="./assets/css/main.css">
      <title>Landdrup danseskole</title>
    </head>

    <body>
        
            <header>
                <nav>
                    <div class="nav-wrapper ">
                        <div class="fixed-action-btn">
                            <a href="#" data-activates="mobile-nav" class="btn-floating btn-large button-collapse black-text"><i class="material-icons">menu</i></a>
                        </div>
                    <a href="./" class="brand-logo">Landdrup danseskole</a>
                        <ul class="right hide-on-med-and-down">
                            <li><a href="./index.php?p=home">Forside</a></li>
                            <li><a href="./index.php?p=instructors">Instruktører</a></li>
                            <li><a href="./index.php?p=styles/index">Stilarter</a></li>
                            <li><a href="./index.php?p=registration">Tilmelding</a></li>
                            <li><a href="./index.php?p=contact">Kontakt</a></li>
                            <?php
                                if($user->checkSession()){
                                    ?>
                                    <li><a class="dropdown-button" href="#!" data-activates="dropdownFull"><i class="material-icons left">perm_identity</i><?=$_SESSION['userFullname']?><i class="material-icons right">arrow_drop_down</i></a></li>

                                    <?php
                                }else{
                                    ?>
                                    <li><a href="./index.php?p=Login"><i class="material-icons right">perm_identity</i>Login</a></li>
                                    <?php
                                }
                            ?>
                        </ul>
                        <ul id="dropdownFull" class="dropdown-content">
                            <li><a href="./index.php?p=profile/home">Min konto</a></li>
                            <?php
                                if((int)$_SESSION['roleLevel'] >= 50){
                                    ?>
                                <li><a href="./admin/">Kontrolpanel</a></li>
                                    <?php
                                }
                            ?>
                            <li class="divider"></li>
                            <li><a href="./index.php?p=logout">Log ud</a></li>
                        </ul>
                        <!--Mobile side-nav-->
                        <ul id="mobile-nav" class="side-nav">
                            <li>
                                <div class="userView">
                                    <div class="background">
                                        <img src="http://placehold.it/300x200">
                                    </div>
                                    <?php
                                        if($user->checkSession()){
                                    ?>
                                    <a href="#!user"><img class="circle" src="http://placehold.it/80x80"></a>
                                    <a href="#!name"><span class="white-text name"><?=$_SESSION['userFullname']?></span></a>
                                    <a href="#!email"><span class="white-text email"><?=$_SESSION['userEmail']?></span></a>
                                        <?php } ?>
                                </div>
                            </li>
                            <li><a href="./index.php?p=home">Forside</a></li>
                            <li><a href="./index.php?p=instructors">Instruktører</a></li>
                            <li><a href="./index.php?p=styles/index">Stilarter</a></li>
                            <li><a href="./index.php?p=registration">Tilmelding</a></li>
                            <li><a href="./index.php?p=contact">Kontakt</a></li>
                            <?php
                                if($user->checkSession()){
                                    ?>
                                    <li><a href="./index.php?p=profile/home"><i class="material-icons right">perm_identity</i>Min konto</a></li> 
                                    <?php
                                        if((int)$_SESSION['roleLevel'] >= 50){
                                            ?>
                                        <li><a href="./admin/">Kontrolpanel</a></li>
                                            <?php
                                        }
                                    ?>
                                    <li class="divider"></li>
                                    <li><a href="./index.php?p=logout">Log ud</a></li>
                                    <?php
                                }else{
                                    ?>
                                    <li><a href="./index.php?p=login"><i class="material-icons right">perm_identity</i>Login</a></li>
                                    <?php
                                }
                            ?>
                            
                        </ul>
                    </div>
                </nav>
                 <?php
                    if(!$user->checkSession() && $router->route !== 'login'){
                ?>
                <!--Login modal-->
                <div id="LoginModal" class="modal">
                    <div class="modal-content">
                        <div class="row container">
                        <h4>Login</h4>
                        <form action="./index.php?p=login" method="post" class="col s12">
                         
                        <div class="row">
                            <div class="input-field col s10">
                            <i class="material-icons prefix">email</i>
                            <input type="email" name="email" id="icon_prefixEmail" class="validate" required>
                            <label for="icon_prefixEmail">E-mail</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s10">
                            <i class="material-icons prefix">vpn_key</i>
                            <input type="password" name="password" id="icon_prefixPassword" class="validate" required>
                            <label for="icon_prefixPassword">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s10">
                              <button class="btn waves-effect waves-light right" type="submit" name="btnLogin">Login
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                    </div>
                    
                </div>
                <?php
                    }
                ?>
            </header>
            <main class="">
                <?php include $partialView ?>
            </main>
            <footer class="page-footer">
            <div class="container">
                <div class="row">
                <div class="col l6 s12">
                    <h5 class="black-text">Footer Content</h5>
                    <p class="text-darken-4">You can use rows and columns here to organize your footer content.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="">Links</h5>
                    <ul>
                    <li><a class="text-darken-3" href="#!">Link 1</a></li>
                    <li><a class="text-darken-3" href="#!">Link 2</a></li>
                    <li><a class="text-darken-3" href="#!">Link 3</a></li>
                    <li><a class="text-darken-3" href="#!">Link 4</a></li>
                    </ul>
                </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                © 2017 Landdrup danseskole 
                </div>
            </div>
            </footer>
        

        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
        <!-- Compiled and minified JavaScript -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
        <script src="./assets/js/app.js"></script>
    </body>
  </html>