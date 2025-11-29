<br>
<br>
<br>
<br>
<br>

<form accept-charset="utf-8"  id="Registrar" method="POST" enctype="multipart/form-data">
  <div class="jumbotron">
  <div class="form-group center  ">
    <label class="btn btn-warning btn-file btn-block glyphicon glyphicon-folder-open "> | <b><span class="font">SUBIR CANCIONES</span> </b>
    <input type="file" multiple name="files[]" accept="audio/*" id="Cancion" style="display: none;">
    </label>
    <span class="text-muted " id="Maximo"><br>Seleccione un maximo  de 5 canciones.</span>         
  </div>       
  <div class="form-group  form-inline">
    <label class="" for="Lista">LISTAS</label><br>
    
     <select name="categoria" id="categoria" class="form-control">
      <option value="Pop">Pop</option>
      <option value="Rock">Rock</option>
      <option value="Hip-Hop">Hip-Hop</option>
      <option value="Jazz">Jazz</option>
      <option value="Clásica">Clásica</option>
      <option value="Electrónica">Electrónica</option>
      <option value="Reguetón">Reguetón</option>
      <option value="Country">Country</option>
      <option value="Blues">Blues</option>
      <option value="Metal">Metal</option>
    </select>
  </div>
  <!-- <script>
   
    const username = <?= isset($_SESSION["usuario"]) ? json_encode($_SESSION["usuario"]) : '""' ?>;

    console.log(viewAñadir, username);
</script> -->

  <hr/>      
  <div class="row">       
     <div class="form-group">    
       <center>
        <button class="btn btn-success btn-sm  glyphicon glyphicon-floppy-saved" type="submit" id="btnRegistrar">
          <b><span class="font">REGISTRAR</span></b>
        </button>
       <div class="btn btn-danger btn-sm  glyphicon glyphicon-floppy-remove" id="Cancelar"> <b><span class="font">CANCELAR</span></b>
       </div>
       </center> 
     </div>      
  </div>   
</div>
<br>

  <div class="AlertaE"></div>
  <div class="Alerta"></div>
 
</form>  
