<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/php/config/config.php");
if (!logado() || $account['nivel']<4) {
    Header('Location: ./login/');
    exit();
}
$Statistics = json_decode(file_get_contents(_API_HOST."statistics.php"));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Administração - Project Marvel</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css?version=0.12.4">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css?version=0.12.4" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="/js/default.js"></script>
    <link rel="stylesheet" type="text/css" href="/c68059ff9075a67037d15000881f9ae4/css/layout.css?version=0.12.4">
</head>
<body>
<header>
    <nav class="navbar navbar-light bg-light">
         <div class="justify-content-end">
            <a class="navbar-brand" href="/c68059ff9075a67037d15000881f9ae4/" style="color: rgba(0,0,0,.9);">
                <img src="http://4.bp.blogspot.com/-KP-zKcxyQdY/VionvlldtfI/AAAAAAAAAKM/iKx03ihYOIQ/s1600/PB-ICON.png" width="30" height="30" class="d-inline-block align-top">
                Point Blank Marvel
            </a>
         </div>
     

        <ul class="nav nav-tabs justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" href="/c68059ff9075a67037d15000881f9ae4/">Controle</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/">Site</a>
            </li>

            <!-- Notificações -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="badge badge-danger ml-2">0</span> <i class="fas fa-bell"></i></a>


                <div class="dropdown-menu padding-0 dropdown-menu-right ">
                    vazio
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Minha conta</a>
                <div class="dropdown-menu padding-0 dropdown-menu-right menu-user">
                    <a class="ovl-h" href="#"><span class="left">Alterar dados</span> <span class="right"><i class="fas fa-user-edit"></i></span></a>
                    <a class="ovl-h" href="/player/00000/" target="_blank"><span class="left">Informações</span> <span class="right"><i class="fas fa-info-circle"></i></span></a>
                    <a class="ovl-h" href="?bye_admin"><span class="left">Sair</span> <span class="right"><i class="fas fa-sign-out-alt"></i></span></a>
                </div>
            </li>
            

        </ul>
       
    </nav>
</header>
<noscript><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Seu navegador não suporta <span>JavaScript</span>, o site não funcionará corretamente!<img src="/img/layout/noscript.png"></noscript>
<div class="corpo">
<aside>
    <div class="info_adm ovl-h">
        <div class="left">
           <img src="/img/patentes/400x400/<?php if($account['rank'] > 54){echo 54;}else{echo $account['rank'];}?>.png"> 
        </div>
        <div class="right">
            <?php 
            if (empty($account['nick'])) {
                echo "<p class=\"text-secondary\">".$account['usuario']."</p>";
            }else{
                 echo "<p >".$account['nick']."</p>";
            }
            if ($account['online'] === true) {
                echo "<span class='text-success bold'>Online</span>";
            }else{
                echo "<span class='text-danger bold'>Offline</span>";
            }
            ?>
       </div>
    </div>

    <div id="MainMenu">
        <div class="list-group">

            <a href="#sub-menu-10" class="list-group-item radius-0 list-group-item-action d-flex justify-content-between align-items-center" data-toggle="collapse" data-parent="#MainMenu">Páginas <i class="fa fa-caret-down"></i></a>
            <div class="collapse" id="sub-menu-10">
                <a href="#sub-sub-menu-2" class="list-group-item list-group-item-action lgi-sub radius-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-parent="#sub-sub-menu-2">Noticias <i class="fa fa-caret-down"></i></a>
                <div class="collapse list-group-submenu" id="sub-sub-menu-2">
                    <a href="/c68059ff9075a67037d15000881f9ae4/?adminPage=noticias&subPage=postar" class="list-group-item lgi-sub-sub radius-0" data-parent="#sub-sub-menu-2">Adicionar</a>

                    <a href="/c68059ff9075a67037d15000881f9ae4/?adminPage=noticias&subPage=lista" class="list-group-item lgi-sub-sub radius-0" data-parent="#sub-sub-menu-2">Editar</a>
                    <a href="/c68059ff9075a67037d15000881f9ae4/?adminPage=noticias&subPage=lista.php&lixeira" class="list-group-item lgi-sub-sub radius-0" data-parent="#sub-sub-menu-2">Lixeira</a>
                </div>

                <a href="?adminPage=pages&subPage=download" class="list-group-item list-group-item-action lgi-sub radius-0 d-flex justify-content-between align-items-center">Download</a>
            </div>


            <a href="?adminPage=contas&subPage=lista" class="list-group-item radius-0 list-group-item-action d-flex justify-content-between align-items-center">Contas  <i style="color:#0c5460;" class="fas fa-users"></i></a>


            <a href="#sub-menu-20" class="list-group-item radius-0 list-group-item-action d-flex justify-content-between align-items-center" data-toggle="collapse" data-parent="#MainMenu">Cash <i class="fa fa-caret-down"></i></a>
            <div class="collapse" id="sub-menu-20">
                <a href="?adminPage=cash&subPage=pincode" class="list-group-item list-group-item-action lgi-sub radius-0 d-flex justify-content-between align-items-center">Pincode</a>

                <a href="JavaScript:void(0);" class="list-group-item list-group-item-action lgi-sub radius-0 d-flex justify-content-between align-items-center">Cupom</a>
            </div>


            <a href="#sub-menu-25" class="list-group-item radius-0 list-group-item-action d-flex justify-content-between align-items-center" data-toggle="collapse" data-parent="#MainMenu">BANIMENTOS <i class="fa fa-caret-down"></i></a>
            <div class="collapse" id="sub-menu-25">
                <a href="JavaScript:void(0);" class="list-group-item list-group-item-action lgi-sub radius-0 d-flex justify-content-between align-items-center">Contas</a>
                
                <a href="?adminPage=cash&subPage=pincode" class="list-group-item list-group-item-action lgi-sub radius-0 d-flex justify-content-between align-items-center">MAC & IP</a>

            </div>



            <a href="#" class="list-group-item radius-0 list-group-item-action d-flex justify-content-between align-items-center">Servidor <i style="color:#0c5460;" class="fas fa-server"></i></a>


            <a href="#" class="list-group-item radius-0 list-group-item-action d-flex justify-content-between align-items-center">Suporte <span class="badge badge-dark badge-pill">0</span></a>


            <a href="#sub-menu-30" class="list-group-item radius-0 list-group-item-action d-flex justify-content-between align-items-center" data-toggle="collapse" data-parent="#MainMenu">Avançado <i class="fa fa-caret-down"></i></a>
            <div class="collapse" id="sub-menu-30">
                <a href="?adminPage=conexoes" class="list-group-item list-group-item-action lgi-sub radius-0 d-flex justify-content-between align-items-center">Conexões</a>

                <a href="#" class="list-group-item list-group-item-action lgi-sub radius-0 d-flex justify-content-between align-items-center">Problemas <span class="badge badge-danger badge-pill">0</span></a>
            </div>


        </div>
    </div>
</aside>

<main>
    <?php 
    $page = @preg_replace("/[^0-9.A-z_-]/", "", $_GET['adminPage']);

    if (empty($page))
        $page = 'dashboard';

    $file = $_SERVER['DOCUMENT_ROOT']."/c68059ff9075a67037d15000881f9ae4/paginas/".$page."/index.php";
    if(file_exists(stream_resolve_include_path($file))){
        include_once($file);
    }else{
        echo "<h3>Página não encontrada</h3>";
    }
    ?>
</main>

<div class="both"></div>
</div> <!-- Fim DIV corpo -->


<footer>
    Painel de administração
</footer>
</body>
</html>
