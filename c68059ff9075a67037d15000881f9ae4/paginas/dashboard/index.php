<?php if (!logado() || $account['nivel']<4) {die('Sem permissão!');}?>
<div class="row">
    <div class="col-lg-12">
        <h1> Admin Dashboard </h1>
    </div>
</div>
<hr/>
<!--BLOCK SECTION -->
<div class="row">
    <div class="col-lg-12">
        <div style="text-align: center;">
            <a href="./?adminPage=contas&subPage=lista&p=1&filtro=2" class="badge badge-primary"><?php echo $Statistics->accounts->PlayersOn;?> Players online</a>
            <a href="?adminPage=contas&subPage=lista" class="badge badge-primary"><?php echo $Statistics->accounts->AllPlayers;?> Contas</a>
            <a href="?page=contas/players.php&filtro=4" class="badge badge-warning"><?php 
                $sql = "SELECT * from contas WHERE player_name = '' ";
                echo select_db($sql)->rowCount();
                ?>  Contas incompletas</a>
        </div>
    </div>
</div>
<!--END BLOCK SECTION -->
<hr/>
<!--TABLE, PANEL, ACCORDION AND MODAL  -->
<div class="row">
    <div class="col-lg-6">
        

        


    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Download #1</span>
                </div> 
                <input type="text" class="form-control" placeholder="url" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Definir</button>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Download #2</span>
                </div> 
                <input type="text" class="form-control" placeholder="url" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Definir</button>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Download #3</span>
                </div> 
                <input type="text" class="form-control" placeholder="url" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Definir</button>
                </div>
            </div>
        </div>
    </div>


</div>
<!--TABLE, PANEL, ACCORDION AND MODAL  -->

                