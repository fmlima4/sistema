<!DOCTYPE html>
<html lang="en">

<body>

<div class="row" >
  <form action="/sistema/calendar2/pesquisar" method="post">
    <div class="col-sm-9">
      <div class="form-group">
        <input name="search" class="form-control" id="search1" type="text"
          placeholder="Filtrar Usuario " value="<?php echo $view_termo1??null ;?>">  
          <span class="input-group-btn"></span>
      </div>
    </div>


    <div class="col-sm-1">
      <button class="btn btn-primary btn-sm pull-left" type="submit">Filtrar</button>
    </div>

  </form>
  

</div>


	<div id="list" class="row">
		<div class="table-responsive col-md-12">
			<table class="table table-striped" cellspacing="30" cellpadding="30" id="clientes">
				<thead>
					<tr>
						<th>ID</th>
						<th>Cliente</th>
						<th>Inicio</th>
						<th>Fim</th>
						<th>Descrição</th>
						<th>Usuario</th>
            <th>Importancia</th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				
				<tbody>

					<?php foreach ( $tarefas as $tarefa ) {?>
						<tr>
							<td><?php echo $tarefa->idevento; ?></td> 
							<td><?php echo $tarefa->cnome; ?></td>    
							<td><?php echo $tarefa->inicio; ?></td>
							<td><?php echo $tarefa->fim; ?></td>
							<td><?php echo $tarefa->descricaoEvento; ?></td>
							<td><?php echo $tarefa->user; ?> </td>
              <td><?php echo $tarefa->importancia; ?> </td>
							<td class="actions">
               <a data-toggle="modal" data-target="#modalEvento" 
                    class="btn btn-primary btn-sm ">Re-agendar</a>
                <a title="Deletar" class="btn btn-danger btn-sm fa fa-trash" 
                    href="<?php echo base_url() . 'calendar2/deletar/' . $tarefa->idevento; ?>" onclick="return confirm('Confirma a exclução deste registro?')"></a>
							</td>		

						</tr>	 	 	  	
						  	
				 	<?php } ?>
				</tbody>
			</table>
			 <h4><?php echo $this->session->flashdata('mensagem');?></h4>
        <h4><?php echo $this->session->flashdata('mensagemErro');?></h4>
		</div>
	</div>	

    <div class="row">
      <div class="col-sm-10" >
        <?php echo $pagination; ?>
      </div>
      <div class="col-sm-2" >
        <a class="btn btn-primary btn-sm" download="relatorio de tarefas atrasadas.xls" href="#" 
        onclick="return ExcellentExport.excel(this, 'clientes', 'relatorio');">Export to Excel</a>
      </div>

    </div>


</body>


<!-- Modal de inserir evento -->
<div class="modal fade" id="new_event" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header  bg-red"">
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Adicionar evento</h4>
      </div>
      <div class="modal-body">
       
       <?php echo form_open('calendar2/new_event', 'id="form-events"'); ?>
        
        <form action="" method="post" ENCTYPE="multipart/form-data">
          <div class="row">
            <div class="form-group col-md-6">
                <label for="nomeEvento">Nome Cliente</label> 
                <input type="text" class="form-control" id="nomeEvento" name="nomeEvento" placeholder="informe o nome do cliente" required
                value="<?php echo isset($view_enome) ? $view_enome: '' ; ?>">
            </div>  

            <div class="form-group col-md-6">
              <label for="user">Responsavel</label> 
              <input type="text" class="form-control" id="user" 
              name="user" readonly value="<?php echo $_SESSION['usuario_logado']['username']; ?> "/>
            </div>
          </div> 

          <div class="row"> 
            <div class="col-md-6">
              <label for="inicio">Data</label>
            </div>
            <div class="col-md-6">
              <label for="importancia">Prioridade</label>
            </div>
            <div class="form-group col-md-6">
              <div class="input-group date">
                <input type="text" class="form-control date" id="inicio" name="inicio" required
                 placeholder="Data de inicio" value="<?php echo isset($view_inicio) ? $view_inicio: '' ; ?>">
                <div class="input-group-addon"> 
                  <span class="glyphicon glyphicon-th"></span>
                </div>
              </div>
            </div>

            <div class="form-group col-md-6">
              <div class="col-md-2">
                <input type="radio" name="importancia" value="Alta" checked> Alta<br>
              </div>
              <div class="col-md-2">
                <input type="radio" name="importancia" value="Media"> Media<br>
              </div>
              <div class="col-md-2">
                <input type="radio" name="importancia" value="Baixa"> Baixa<br>
              </div>
            </div>

          </div>

           <div class="row"> 
            <div class="form-group col-md-12">
              <label for="descricaoEvento">Descrição</label> 
              <input type="text" class="form-control" id="descricaoEvento" name="descricaoEvento" placeholder="descreva a tarefa" required
                value="<?php echo isset($view_descricaoEvento) ? $view_descricaoEvento: '' ; ?>">
            </div> 
           </div>


          <div class="row">
            <div class="col-md-12">
                <input href="http://localhost/sistema/calendar2/new_event"  type="submit" class="btn btn-primary" name="btsalvar" value="Salvar" /> 
                    <a data-dismiss="modal" class="btn btn-default">Cancelar</a>
            </div>

        <?php echo form_close(); ?>
        </div>    
        </form>
      </div>

      </div>
    </div>
  </div><!-- /.modal -->


<!-- Modal visualizar-->

<div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="mymodelLabel">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header bg-red">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="mymodelLabel"> Editar Evento</h4>
    </div>

    <div class="modal-body">
      <?php echo form_open('calendar2/updateEvents2', 'id="form-events-update"'); ?>
       <form action="" method="post" ENCTYPE="multipart/form-data">

       <input type="hidden" name="ecod" id="id"/>
       <input type="hidden" name="codigoCliente" id="ccod"/>


        <div class="row">
          <div class="form-group col-md-6">
              <label for="nomeEvento">Nome Cliente</label> 
                <input type="text" class="form-control" id="mtitulo" name="titulo"/>
          </div>  

          <div class="form-group col-md-6">
            <label for="user">Responsavel</label> 
            <input type="text" class="form-control" id="autor" name="responsavel"/>
          </div>
        </div> 

        <div class="row"> 
          <div class="form-group col-md-6">
            <div class="input-group date">
              <input type="text" class="form-control date" id="inicioEdit" name="data" />
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
            </div>
          </div>

        <div class="form-group col-md-6">
            <label for="importancia">Prioridade</label> 
            <input type="text" class="form-control" name="importancia" id="importanciaEdit" />
        </div>
      </div>

      <div class="row"> 
        <div class="form-group col-md-12">
          <label for="descricaoEvento">Descrição</label> 
          <input type="text" class="form-control" id="descricaoEventoEdit" name="descricao"/>
        </div> 
      </div>

    </div>
     
     <?php $cliente = '.titulo';?>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" style="background-color:lightgreen" id="history"
      href="<?php echo base_url() . 'comments/pesquisar1/'. $cliente; ?>">Historico</button>
      <button type="button" class="btn btn-default" id="closeM" data-dismiss="modal">Cancelar</button>
      <input  type="submit" class="btn btn-primary" name="btsalvar" value="Atualizar" />
    </div>
    </div>
    <?php echo form_close(); ?>
    </form>
  </div>
</div>
<!-- /.modal -->