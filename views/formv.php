<?php include('_header.php'); ?>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js"></script>


<script>
    $(document).ready(function () {
        $('#status_div_cb_subitem input[type=checkbox]').click(function () {
            if ($("#status_div_cb_subitem :checked").length == 1 && $("#cb_subitem").is(":checked") == true) {
                // se marcar que 'possui subitem', esconder os campos de ponto e torná-los não obrigatórios:
                $('#div_item_ponto').hide();
                document.getElementById("tipo_und_desc").required = false;
                document.getElementById("tipo_und_valor").required = false;
                document.getElementById("qtd_max_und").required = false;
                document.getElementById("ponto_por_und").required = false;
                document.getElementById("docprob_item").required = false;
            }
            else {
                $('#div_item_ponto').show();
                document.getElementById("tipo_und_desc").required = true;
                document.getElementById("tipo_und_valor").required = true;
                document.getElementById("qtd_max_und").required = true;
                document.getElementById("ponto_por_und").required = true;
                document.getElementById("docprob_item").required = true;
            }
        });


        $('#status_div_cb_item_bonus input[type=checkbox]').click(function () {
            if ($("#status_div_cb_item_bonus :checked").length == 1 && $("#cb_possui_bonus").is(":checked") == true) {
                // se marcar que 'possui bônus', mostra os campos de ponto-bônus e torná-los obrigatórios:
                $('#div_item_bonus').show();
                document.getElementById("tipo_und_descb").required = true;
                document.getElementById("tipo_und_valorb").required = true;
                document.getElementById("qtd_max_undb").required = true;
                document.getElementById("ponto_por_undb").required = true;
                document.getElementById("docprob_itemb").required = true;
            }
            else {
                $('#div_item_bonus').hide();
                document.getElementById("tipo_und_descb").required = false;
                document.getElementById("tipo_und_valorb").required = false;
                document.getElementById("qtd_max_undb").required = false;
                document.getElementById("ponto_por_undb").required = false;
                document.getElementById("docprob_itemb").required = false;
            }
        });

/*   --    */
        $('#status_div_cb_class input[type=checkbox]').click(function () {
            if ($("#status_div_cb_class :checked").length == 1 && $("#cb_class").is(":checked") == true) {
                // se marcar que 'possui subitem', esconder os campos de ponto e torná-los não obrigatórios:
                $('#div_subitem_ponto').hide();
                document.getElementById("tipo_und_desc").required = false;
                document.getElementById("tipo_und_valor").required = false;
                document.getElementById("qtd_max_und").required = false;
                document.getElementById("ponto_por_und").required = false;
                document.getElementById("docprob_item").required = false;
            }
            else {
                $('#div_subitem_ponto').show();
                document.getElementById("tipo_und_desc").required = true;
                document.getElementById("tipo_und_valor").required = true;
                document.getElementById("qtd_max_und").required = true;
                document.getElementById("ponto_por_und").required = true;
                document.getElementById("docprob_item").required = true;

            }
        });


        $('#status_div_cb_subitem_bonus input[type=checkbox]').click(function () {
            if ($("#status_div_cb_subitem_bonus :checked").length == 1 && $("#cb_subitem_possui_bonus").is(":checked") == true) {
                // se marcar que 'possui bônus', mostra os campos de ponto-bônus e torná-los obrigatórios:
                $('#div_subitem_bonus').show();
                document.getElementById("tipo_und_descb").required = true;
                document.getElementById("tipo_und_valorb").required = true;
                document.getElementById("qtd_max_undb").required = true;
                document.getElementById("ponto_por_undb").required = true;
                document.getElementById("docprob_itemb").required = true;
            }
            else {
                $('#div_subitem_bonus').hide();
                document.getElementById("tipo_und_descb").required = false;
                document.getElementById("tipo_und_valorb").required = false;
                document.getElementById("qtd_max_undb").required = false;
                document.getElementById("ponto_por_undb").required = false;
                document.getElementById("docprob_itemb").required = false;
            }
        });


    });
</script>



<a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

<!-- show registration form, but only if we didn't submit already -->
<?php if (!$form->registration_successful && !$form->verification_successful) { ?>

    <div class="container">
        <h3>Cadastrar Itens do Formulário</h3>
        <p>Cadastre na ordem: Eixo > SubEixo > Item > SubItem</p>  
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home">Eixo</a></li>
            <li><a href="#menu1">Sub Eixo</a></li>
            <li><a href="#menu2">Item</a></li>
            <li><a href="#menu3">SubItem</a></li>
            <li><a href="#menu4">Classificação</a></li>
            <li><a href="#menu5">[ Tabela Final ]</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <h4>NOVO EIXO</h4>
                <form method="post" action="formc.php" name="registerform">
                    Eixo:<input id="nome_eixo" type="text" name="nome_eixo" required />
                    Descrição: <input id="desc_eixo" type="text" name="desc_eixo" required /> </p>

                    <button type="submit" class="btn btn-primary" name="form_new_eixo">Cadastrar Eixo</button>
                </form>					

                <div class="container">
                    <div class="row"></div>
                    <div class="row">
                        </p>
                        </p>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th width="33%">Eixo</th>
                                    <th width="33%">Descrição</th>                                
                                    <th width="15%">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //include 'database.php';
                                require_once 'database.php';
                                $pdo = Database::connect();
                                $sql = 'SELECT * FROM eixo';
                                echo $sql;
                                foreach ($pdo->query($sql) as $row) {
                                    echo '<tr>';
                                    echo '<td width="100">' . $row['nome_eixo'] . '</td>';
                                    echo '<td width="100">' . $row['desc_eixo'] . '</td>';
                                    echo '<td width="5">';
                                    echo '<a class="btn btn-primary btn-sm" href="read.php?id=' . $row['id_eixo'] . '">Detalhes</a>';
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-success btn-sm" href="update.php?id_eixo=' . $row['id_eixo'] . '">Editar</a>';
                                    // echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id_eixo'] . '">Excluir</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                Database::disconnect();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- /container -->



            </div>  <!-- end tab home -->

            <div id="menu1" class="tab-pane fade">
                <h4>NOVO SUBEIXO</h4>
                <form method="post" action="formc.php" name="registerform">					

                    Pertence ao Eixo:                               
                    <?php
                    require_once 'database.php';
                    $pdo2 = Database::connect();
                    $sql2 = 'SELECT * FROM eixo';
                    echo '<select class="form-control custom" type="text" name="id_eixo" id="id_eixo">';
                    foreach ($pdo2->query($sql2) as $row) {
                        echo '<option value="' . $row['id_eixo'] . '">' . $row['nome_eixo'] . '</option>';
                    }
                    echo "</select>";
                    Database::disconnect();
                    ?>										
                    Nome do SubEixo: <input id="nome_subeixo" type="text" name="nome_subeixo" required />
                    Descrição: <input id="desc_subeixo" type="text" name="desc_subeixo" required />	
                    Pont Max do SubEixo:  <input type="text" id="pont_max_subeixo" name="pont_max_subeixo"/></p>	

                    <button type="submit" class="btn btn-primary" name="form_new_subeixo">Cadastrar SubEixo</button>				
                </form>		


                <div class="container">
                    <div class="row">
                        </p>
                        </p>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10%">SubEixo</th>
                                    <th width="60%">Descrição</th>  
                                    <th width="10%">Pontuação Máxima</th>    									
                                    <th width="20%">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //include 'database.php';
                                require_once 'database.php';
                                $pdo = Database::connect();
                                $sql = 'SELECT * FROM subeixo';
                                echo $sql;
                                foreach ($pdo->query($sql) as $row) {
                                    echo '<tr>';
                                    echo '<td width="10">' . $row['nome_subeixo'] . '</td>';
                                    echo '<td width="10">' . $row['desc_subeixo'] . '</td>';
                                    echo '<td width="5">' . $row['pont_max_subeixo'] . '</td>';
                                    echo '<td width="10">';
                                    echo '<a class="btn btn-primary btn-sm" href="read.php?id=' . $row['id_subeixo'] . '">Detalhes</a>';
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-success btn-sm" href="update.php?id_eixo=' . $row['id_subeixo'] . '">Editar</a>';
                                    // echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id_subeixo'] . '">Excluir</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                Database::disconnect();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- /container -->


            </div>

            <div id="menu2" class="tab-pane fade">
                <h4>NOVO ITEM</h4>
                <form method="post" action="formc.php" name="registerform">	
                    Pertence ao SubEixo:                               
                    <?php
                    require_once 'database.php';
                    $pdo2 = Database::connect();
                    $sql2 = 'SELECT * FROM subeixo';
                    echo '<select class="form-control custom" type="text" name="id_subeixo" id="id_subeixo">';
                    foreach ($pdo2->query($sql2) as $row) {
                        echo '<option value="' . $row['id_subeixo'] . '">' . $row['nome_subeixo'] . '</option>';
                    }
                    echo "</select>";
                    Database::disconnect();
                    ?>			

                    Nome do Item: <input id="nome_item" type="text" name="nome_item" required />
                    Descrição: <textarea rows="3" name="desc_item" id="desc_item" required></textarea>					

                    <div id="status_div_cb_subitem">
                        </p><label><input type="checkbox" value="1" id="cb_subitem" name="cb_subitem">Possui SubItem</label></br>	
                    </div>														   
                    <div id="div_item_ponto">

                        <!--    private function registerNewPonto($id_pontopai, $tipo_und_valor, $tipo_und_desc, $qtd_max_und, $ponto_por_und) {
                        -->	
                        Quantidade de pontos por unidade:  <input type="number" step="any" min=0.5 id="ponto_por_und" name="ponto_por_und" placeholder="Ex: 1 , 1.5 , 10 ... (somente número)" required /></p>	
                        Valor de cada unidade:  <input type="number" id="tipo_und_valor" name="tipo_und_valor" placeholder="Ex: a cada 1, a cada 3 ... (somente número)" required /> </p>	
                        Tipo de unidade: <input id="tipo_und_desc" type="text" name="tipo_und_desc" placeholder="Ex: hora, artigo, projeto, capítulo ..."required /> </p>			
                        Quantidade máxima de unidades:  <input type="number" id="qtd_max_und" name="qtd_max_und" placeholder="Ex: 60 horas (somente número)" required /></p>		
                        </p></p>
                        Documentação Comprobatória: <textarea rows="3" name="docprob_item" id="docprob_item" required ></textarea>	

                        <div id="status_div_cb_item_bonus">
                            </p><label><input type="checkbox" value="1" id="cb_possui_bonus" name="cb_possui_bonus">Possui Pontuação Bônus</label></br>	
                        </div>	
                        <div hidden id="div_item_bonus">
                            <h4>Pontuação Bônus</h4>
                            <!--    private function registerNewPonto($id_pontopai, $tipo_und_valor, $tipo_und_desc, $qtd_max_und, $ponto_por_und) {-->	
                            Quantidade de pontos por unidade:  <input type="number" step="any" min=0.5 id="ponto_por_undb" name="ponto_por_undb" placeholder="Ex: 1 , 1.5 , 10 ... (somente número)" /></p>	
                            Valor de cada unidade:  <input type="number" id="tipo_und_valorb" name="tipo_und_valorb" placeholder="Ex: a cada 1, a cada 3 ... (somente número)" /> </p>	
                            Tipo de unidade: <input id="tipo_und_descb" type="text" name="tipo_und_descb" placeholder="Ex: hora, artigo, projeto, capítulo ..." /> </p>			
                            Quantidade máxima de unidades:  <input type="number" id="qtd_max_undb" name="qtd_max_undb" placeholder="Ex: 60 horas (somente número)"  /></p>		
                            </p></p>
                        </div> <!-- fim div_bonus -->				
                    </div>  <!-- fim div_item -->

                    <button type="submit" class="btn btn-primary" name="form_new_item" OnClick="MostrarTab">Cadastrar Item</button>				
                </form>		




                <div class="container">
                    <div class="row">
                        </p>
                        </p>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">SubEixo</th>
                                    <th width="5%">Item</th>
                                    <th width="20%">Descrição</th>  
                                    <th width="20%">Pontuação</th>  

                                    <th>Document Comp:</th>  										
                                    <th width="25%">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //include 'database.php';
                                require_once 'database.php';
                                $pdo = Database::connect();
                                //$sql = 'SELECT * FROM item';
                                //$sql = 'SELECT DISTINCT * FROM subeixo INNER JOIN item ON item.id_subeixo=subeixo.id_subeixo';
                                $sql = 'SELECT DISTINCT * FROM item 
								LEFT JOIN  subeixo ON item.id_subeixo=subeixo.id_subeixo
								LEFT JOIN ponto ON ponto.id_ponto=item.id_ponto';
                                echo $sql;
                                foreach ($pdo->query($sql) as $row) {
                                    echo '<tr>';
                                    echo '<td>' . $row['nome_subeixo'] . '</td>';
                                    echo '<td>' . $row['nome_item'] . '</td>';
                                    echo '<td>' . $row['desc_item'] . '</td>';

                                    if ($row['tipo_und_valor'] == 0) {
                                        echo '<td> sem pontuacao </td>';
                                    } else {
                                        if ($row['qtd_max_und'] == 0) {
                                            echo '<td>' . $row['ponto_por_und'] . '&nbsp ponto(s) a cada &nbsp' . $row['tipo_und_valor'] . '&nbsp' . $row['tipo_und_desc'] . '(s)';
                                        } else {
                                            echo '<td>' . $row['ponto_por_und'] . '&nbsp ponto(s) a cada &nbsp' . $row['tipo_und_valor'] . '&nbsp' . $row['tipo_und_desc'] . '&#40s&#41 (máximo &nbsp' . $row['qtd_max_und'] . '&nbsp' . $row['tipo_und_desc'] . '(s))';
                                        }
                                    }

                                    $sql2 = "SELECT DISTINCT * FROM ponto WHERE id_pontopai='" . $row['id_ponto'] . "' and id_pontopai!='0'";
                                    foreach ($pdo2->query($sql2) as $row2) {

                                        if ($row2['tipo_und_valor'] == 0) {
                                            //echo '<td> sem pontuacao </td>';
                                        } else {
                                            if ($row2['qtd_max_und'] == 0) {
                                                echo '</br>BÔNUS :&nbsp' . $row2['ponto_por_und'] . '&nbsp ponto(s) a cada &nbsp' . $row2['tipo_und_valor'] . '&nbsp' . $row2['tipo_und_desc'] . '(s)</td>';
                                                //$pontobonus = "------";
                                                //echo $pontobonus.'</br>';	
                                            } else {
                                                $echo = '</br>BÔNUS :&nbsp' . $row2['ponto_por_und'] . '&nbsp ponto(s) a cada &nbsp' . $row2['tipo_und_valor'] . '&nbsp' . $row2['tipo_und_desc'] . '&#40s&#41 (máximo &nbsp' . $row2['qtd_max_und'] . '&nbsp' . $row2['tipo_und_desc'] . '(s)</td>';
                                            }
                                        }
                                    }


                                    echo '<td>' . $row['docprob_item'] . '</td>';

                                    echo '<td width=250>';
                                    echo '<a class="btn btn-primary btn-sm" href="read.php?id=' . $row['id_subeixo'] . '">Detalhes</a>';
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-success btn-sm" href="update.php?id_eixo=' . $row['id_subeixo'] . '">Editar</a>';
                                    // echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id_subeixo'] . '">Excluir</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                Database::disconnect();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- /container -->	


            </div>	

            <div id="menu3" class="tab-pane fade">
                <h4>NOVO SUBITEM</h4><form method="post" action="formc.php" name="registerform">	
                    Pertence ao SubEixo:                               
                    <?php
                    require_once 'database.php';
                    $pdo2 = Database::connect();
                    $sql2 = 'SELECT * FROM item';
                    echo '<select class="form-control custom" type="text" name="id_subeixo" id="id_subeixo">';
                    foreach ($pdo2->query($sql2) as $row) {
                        echo '<option value="' . $row['id_item'] . '">' . $row['nome_item'] . '</option>';
                    }
                    echo "</select>";
                    Database::disconnect();
                    ?>			

                    Nome do SubItem: <input id="nome_item" type="text" name="nome_item" required />
                    Descrição: <textarea rows="3" name="desc_item" id="desc_item" required></textarea>					

                    <div id="status_div_cb_class">
                        </p><label><input type="checkbox" value="1" id="cb_class" name="cb_class">Possui Classsificação</label></br>	
                    </div>														   
                    <div id="div_subitem_ponto">

                        <!--    private function registerNewPonto($id_pontopai, $tipo_und_valor, $tipo_und_desc, $qtd_max_und, $ponto_por_und) {
                        -->	
                        Quantidade de pontos por unidade:  <input type="number" step="any" min=0.5 id="ponto_por_und" name="ponto_por_und" placeholder="Ex: 1 , 1.5 , 10 ... (somente número)" required /></p>	
                        Valor de cada unidade:  <input type="number" id="tipo_und_valor" name="tipo_und_valor" placeholder="Ex: a cada 1, a cada 3 ... (somente número)" required /> </p>	
                        Tipo de unidade: <input id="tipo_und_desc" type="text" name="tipo_und_desc" placeholder="Ex: hora, artigo, projeto, capítulo ..."required /> </p>			
                        Quantidade máxima de unidades:  <input type="number" id="qtd_max_und" name="qtd_max_und" placeholder="Ex: 60 horas (somente número)" required /></p>		
                        </p></p>
                        Documentação Comprobatória: <textarea rows="3" name="docprob_item" id="docprob_item" required ></textarea>	

                        <div id="status_div_cb_subitem_bonus">
                            </p><label><input type="checkbox" value="1" id="cb_subitem_possui_bonus" name="cb_subitem_possui_bonus">Possui Pontuação Bônus</label></br>	
                        </div>	
                        <div hidden id="div_subitem_bonus">
                            <h4>Pontuação Bônus</h4>
                            <!--    private function registerNewPonto($id_pontopai, $tipo_und_valor, $tipo_und_desc, $qtd_max_und, $ponto_por_und) {-->	
                            Quantidade de pontos por unidade:  <input type="number" step="any" min=0.5 id="ponto_por_undb" name="ponto_por_undb" placeholder="Ex: 1 , 1.5 , 10 ... (somente número)" /></p>	
                            Valor de cada unidade:  <input type="number" id="tipo_und_valorb" name="tipo_und_valorb" placeholder="Ex: a cada 1, a cada 3 ... (somente número)" /> </p>	
                            Tipo de unidade: <input id="tipo_und_descb" type="text" name="tipo_und_descb" placeholder="Ex: hora, artigo, projeto, capítulo ..." /> </p>			
                            Quantidade máxima de unidades:  <input type="number" id="qtd_max_undb" name="qtd_max_undb" placeholder="Ex: 60 horas (somente número)"  /></p>		
                            </p></p>
                        </div> <!-- fim div_bonus -->				
                    </div>  <!-- fim div_subitem -->

                    <button type="submit" class="btn btn-primary" name="form_new_item" OnClick="MostrarTab">Cadastrar Item</button>				
                </form>						


                <div class="container">
                    <div class="row">
                        </p>
                        </p>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">Item</th>
                                    <th width="20%">Descrição</th>  
                                    <th width="5%">Pontuação Máxima</th>    		
                                    <th>Tipo de Pontuação</th>    
                                    <th width="5%">Bônus</th>  
                                    <th>Document Comp:</th>  										
                                    <th width="20%">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once 'database.php';
                                $pdo = Database::connect();
                                $sql = 'SELECT * FROM item where id_itempai!=0';
                                //$sql = 'SELECT DISTINCT * FROM item INNER JOIN subeixo ON item.id_sueixo=subeixo.id_sueixo WHERE id_itempai!=0';
                                echo $sql;
                                foreach ($pdo->query($sql) as $row) {
                                    echo '<tr>';
                                    // echo '<td>' . $row['id_sueixo'] . '</td>';
                                    echo '<td>' . $row['nome_item'] . '</td>';
                                    echo '<td>' . $row['desc_item'] . '</td>';
                                    echo '<td>' . $row['pont_max_item'] . '</td>';
                                    echo '<td>' . $row['desc_pont_item'] . '</td>';
                                    echo '<td>' . $row['bonus_item'] . '</td>';
                                    echo '<td>' . $row['docprob_item'] . '</td>';
                                    echo '<td width=250>';
                                    echo '<a class="btn btn-primary btn-sm" href="read.php?id=' . $row['id_item'] . '">Detalhes</a>';
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-success btn-sm" href="update.php?id_eixo=' . $row['id_item'] . '">Editar</a>';
                                    // echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id_item'] . '">Excluir</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                Database::disconnect();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- /container -->		

            </div>	


            <div id="menu4" class="tab-pane fade">
                <h4>NOVA CLASSIFICAÇÃO</h4>
                <form method="post" action="formc.php" name="registerform1">	

                    Pertence ao Item/SubItem:                               
                    <?php
                    require_once 'database.php';
                    $pdo2 = Database::connect();
                    $sql2 = 'SELECT * FROM item ORDER BY nome_item';
                    echo '<select class="form-control custom" type="text" name="id_item" id="id_item">';
                    foreach ($pdo2->query($sql2) as $row) {
                        echo '<option value="' . $row['id_item'] . '">' . $row['nome_item'] . '</option>';
                    }
                    echo "</select>";
                    Database::disconnect();
                    ?>						

                    Nome da Classificação: <input id="nome_class" type="text" name="nome_class" required />		
                    Pont Max da Classificação: <input type="number" id="pont_max_class" name="pont_max_class"/></p>
                    Tipo de Pontuação: <input id="desc_pont_class" type="text" name="desc_pont_class"/></p>
                    bonus_class <input id="bonus_class" type="number" name="bonus_class"/></p> 
					
                    <button type="submit" class="btn btn-primary" name="form_new_class">Cadastrar Classificação</button>				
                </form>		

                <div class="container">
                    <div class="row">
                        </p>
                        </p>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">Item/Sub</th>    
                                    <th width="35%">Class</th>
                                    <th width="10%">Pont Max</th>  
                                    <th width="15%">Tipo de Pont</th>  	
                                    <th width="5%">Bônus</th>  	
                                    <th width="20%">Opções</th>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //include 'database.php';
                                require_once 'database.php';
                                $pdo = Database::connect();
                                $sql = 'SELECT DISTINCT * FROM class INNER JOIN item ON class.id_item=item.id_item';
                                echo $sql;
                                foreach ($pdo->query($sql) as $row) {
                                    echo '<tr>';
                                    echo '<td>' . $row['nome_item'] . '</td>';
                                    echo '<td>' . $row['nome_class'] . '</td>';
                                    echo '<td>' . $row['pont_max_class'] . '</td>';
                                    echo '<td>' . $row['desc_pont_class'] . '</td>';
                                    // echo '<td>' . $row['bonus_class'] . '</td>';

                                    echo '<td>teste</td>';

                                    echo '<td width=250>';
                                    echo '<a class="btn btn-primary btn-sm" href="read.php?id=' . $row['id_class'] . '">Detalhes</a>';
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-success btn-sm" href="update.php?id_eixo=' . $row['id_class'] . '">Editar</a>';
                                    // echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));
                                    echo '&nbsp;';
                                    echo '<a class="btn btn-danger btn-sm" href="delete.php?id=' . $row['id_class'] . '">Excluir</a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                Database::disconnect();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- /container -->	

            </div>	



            <div id="menu5" class="tab-pane fade">
                <h3>TABELA FINAL</h3>
                <form method="post" action="formc.php" name="registerform">	

                    <?php
                    require_once 'database.php';
                    $pdo = Database::connect();
                    $sql1 = 'SELECT * FROM eixo';

                    foreach ($pdo->query($sql1) as $row) {
                        echo '</p></p>';
                        echo '<h3>Eixo&nbsp' . $row['nome_eixo'] . ' - ' . $row['desc_eixo'] . '</h3>';

                        $sql2 = "SELECT * FROM subeixo WHERE id_eixo='" . $row['id_eixo'] . "'";

                        foreach ($pdo->query($sql2) as $row) {

                            echo '<table class="table table-striped table-bordered">';
                            echo'<thead>';
                            echo'<tr>';
                            echo'<th width="33%">SubEixo:&nbsp' . $row['nome_subeixo'] . ' - ' . $row['desc_subeixo'] . '</th>';
                            echo'<th width="33%">Pontuação Máxima por Intertício:&nbsp' . $row['pont_max_subeixo'] . '</th>';
                            echo'<th width="33%">Documentos Comprobatórios</th>';
                            echo'</tr>';
                            echo'</thead>';
                            echo'<tbody>';


                            //$sql3 = "SELECT * FROM item WHERE id_subeixo='" . $row['id_subeixo'] . "' ORDER BY nome_item";
                            $sql3 = "SELECT * FROM item WHERE id_itempai=0 AND id_subeixo='" . $row['id_subeixo'] . "'";
                            foreach ($pdo->query($sql3) as $row) {
                                echo '<tr>';
                                echo '<td width="33%">' . $row['nome_item'] . ' - ' . $row['desc_item'] . '</td>';
                                if ($row['pont_max_item'] == 0) {
                                    echo '<td width="33%"> </td>';
                                    echo '<td width="33%">  </td>';
                                } else {
                                    echo '<td width="33%">' . $row['pont_max_item'] . ' ' . $row['desc_pont_item'] . '</td>';
                                    echo '<td width="33%">' . $row['docprob_item'] . '</td>';
                                }
                                echo '</tr>';


                                $sql4 = "SELECT * FROM item WHERE id_itempai!=0 AND id_itempai='" . $row['id_item'] . "'";
                                foreach ($pdo->query($sql4) as $row) {
                                    echo '<tr>';
                                    echo '<td width="33%">' . $row['nome_item'] . ' - ' . $row['desc_item'] . '</td>';
                                    if ($row['pont_max_item'] == 0) {
                                        echo '<td width="33%"> </td>';
                                        echo '<td width="33%">' . $row['docprob_item'] . '</td>';
                                    } else {
                                        echo '<td width="33%">' . $row['pont_max_item'] . ' ' . $row['desc_pont_item'] . '</td>';
                                        echo '<td width="33%">' . $row['docprob_item'] . '</td>';
                                    }
                                    echo '</tr>';

                                    $sql4 = "SELECT * FROM class WHERE id_item='" . $row['id_item'] . "'";
                                    foreach ($pdo->query($sql4) as $row) {
                                        echo '<tr>';
                                        echo '<td width="33%"> --- ' . $row['nome_class'] . '</td>';
                                        echo '<td width="33%">' . $row['pont_max_class'] . '</td>';
                                        echo '<td width="33%"> - </td>';
                                        echo '</tr>';
                                    }
                                }
                            }
                            echo'</tbody>';
                            echo '</table>';
                        }
                    }
                    Database::disconnect();
                    ?>

            </div>	



            <script>

                $(document).ready(function () {

                    $(".nav-tabs a").click(function () {
                        $(this).tab('show');
                    });
                    $('.nav-tabs a').on('shown.bs.tab', function (event) {
                        var x = $(event.target).text();         // active tab
                        var y = $(event.relatedTarget).text();  // previous tab
                        $(".act span").text(x);
                        $(".prev span").text(y);
                    });
                });
            </script>
            <!-- FIM TABS-->

        </div>
        </br></br>	

    <?php } ?>


    </br>
    <a href="index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>

    <?php include('_footer.php'); ?>
