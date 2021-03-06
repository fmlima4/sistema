<head>

  <script type="text/javascript">  
    $(function(){
        $("#nomeEvento").autocomplete({
          source: "clientes/get_cliente", // path to the method
          appendTo: $("#new_event")
        });
    }); 
  </script>

  <script>
  $(function(){
      $('.form-control.date').datepicker({
          format: 'yyyy-mm-dd',
          language: 'pt-BR',
          todayHighlight: true
      });
   });
  </script>

<script>

$(document).ready(function() {

  $.post('<?php echo base_url();?>calendar2/getEvents', 
  function(data){
  //alert(data);

    $('#calendar').fullCalendar({
      locale: 'pt-br',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
      defaultDate: new Date(),
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      editable: true,
      events: $.parseJSON(data),

      eventDrop: function(event, delta, revertFunc){
        var id = event.id;
        var fi = event.start.format();
        var ff = event.end.format();
     
        $.post("<?php echo base_url();?>calendar2/updateEvents",
        {
          id:id,
          inicio:fi,
          fim:ff,
        },
        function(data){
          if(data == 1){
            alert('Evento atualizado');
          }else{
            alert('Evento Nao atualizado')
          }
        });    
      },

      eventResize: function(event, delta, revertFunc) {
        var id = event.id;
        var fi = event.start.format();
        var ff = event.end.format();

        $.post("<?php echo base_url();?>calendar2/updateEvents",
        {
          id:id,
          inicio:fi,
          fim:ff,
        },
        function(data){
          if(data == 1){
          //alert('Evento atualizado');
        }else{
         // alert('Evento não atualizado')
        }

        });  
      },

      // eventClick: function(event,jsEvent, view){
      //   $('#calendar').fullCalendar('removeEvents',event.id);
      //  }

      eventRender: function(event, element,data){
        var el = element.html();
        element.html("<div style='width:90%;float:left;'>" + el + "</div><div class='closeee' style='color:red; text-align:right;'>X</div>");

        element.find('.closeee').click(function(){
          if(!confirm("Excluir registro ??")){
            revertFunc();
          }else{
                var id = event.id
                $.post("<?php echo base_url();?>calendar2/deleteEvents",
                {
                  id:id,
                },
                function(data){
                  if(data == 1){
                    $('#calendar').fullCalendar('deleteEvents', event.id);
                  //alert('Tarefa Excluida');
                }else{
                 //alert('Tarefa não Excluida')
                }

                }); 
              }
          });
      },

      eventClick: function(event, jsEvent, view){
        $('#id').val(event.id);
        $('#ccod').val(event.codigoCliente);
        $('#mtitulo').val(event.title);
        $('#autor').val(event.autor);
        $('#inicioEdit').val(event.start);
        $('#importanciaEdit').val(event.impor);
        $('#descricaoEventoEdit').val(event.text);
        $('#modalEvento').modal();
      },

    });
  });
});

$(function(){
      $('.form-control.date').datepicker({
          format: 'yyyy-mm-dd',
          language: 'pt-BR',
          todayHighlight: true
      });
   });

</script>



</head>


<body>

	<div id='calendar'></div>

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
                <input type="text" class="form-control" id="nomeEvento" name="nomeEvento" placeholder="informe o nome do cliente" required>
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
                 placeholder="Data de inicio" >
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
              <input type="text" class="form-control" id="descricaoEvento" name="descricaoEvento" placeholder="descreva a tarefa" required>
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
        <div class="col-md-6">
              <label for="inicio">Data</label>
            </div>
            <div class="col-md-6">
              <label for="importancia">Prioridade</label>
            </div>
          <div class="form-group col-md-6">
            <div class="input-group date">
              <input type="text" class="form-control date" id="inicioEdit" name="data" />
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
            </div>
          </div>

       <div class="form-group col-md-6">
              <div class="col-md-2">
                <input type="radio" name="importanciaEdit" value="Alta" checked> Alta<br>
              </div>
              <div class="col-md-2">
                <input type="radio" name="importanciaEdit" value="Media"> Media<br>
              </div>
              <div class="col-md-2">
                <input type="radio" name="importanciaEdit" value="Baixa"> Baixa<br>
              </div>
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