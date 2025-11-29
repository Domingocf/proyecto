
<br>
<br>
<br>
<br>
<br>

<!-- Agrega el input oculto para el id de la lista -->
<input type="hidden" id="idHidden" value="1">

<div class="jumbotron">
  <div class="panel panel-success center ">
    <div class="panel-heading">
      <h4><b>LISTA DE REPRODUCCIÓN</b></h4>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-4">
          <label class="info" style="color:#000">Lista actual:</label>
        </div>
        <div class="col-sm-7"></div>
      </div>
      <select class="form-control" id="filtroLista">
        <option>Seleccionar lista de reproducción</option>
      </select>
      <div id="mainwrap">
        <div class="row">
          <div id="audiowrap">
            <div id="audio0">
              <audio preload id="audio1" controls="controls">¡Su navegador no soporta Audio HTML5!</audio>
            </div>
            <div id="npTitle" class="mt-2"></div>
            <div class="info mb-2"></div>
            <div id="tracks">
              <a id="btnPrev" class="btn btn-custom" style="background:#3b82f6; color:#fff; margin-right:10px;">&lArr;</a>
              <a id="btnNext" class="btn btn-custom" style="background:#3b82f6; color:#fff;">&rArr;</a>
            </div>
          </div>
          <div id="plwrap">
            <ul id="plList"></ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Asegúrate de que el script se carga después de los elementos -->
<script type="text/javascript" src="../../js/iframe.js"></script>
