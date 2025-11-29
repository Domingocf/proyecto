  $(document).ready(function()
{      
    $(".lis").addClass("act");
    $(".can").removeClass("act");

    cargarListasC();   

    $(document).on("click", ".tbody a", function(e) {
       var tipo = $(this).attr('tipo');  

       if(tipo=="mostrar")
       {
              var id = $(this).attr('id');
              var name = $(this).attr('name');   

           $('#LISTAACTUAL').html("<h4>lista: <b> " + name + " </b></h4>");
           cargarCancionesL(id);
       }

       if(tipo=="eliminar")
       {
              var id = $(this).attr('id');
              var name = $(this).attr('name');   

           $('#LISTAACTUAL').html("<h4>lista: <b> " + name + " </b></h4>");

            EliminarListaConCanciones(id, name);
       }
       if(tipo=="eliminarC")
       {
         var id = $(this).attr('id');
         EliminarCancion(id);
       }
       
       if(tipo=="editar")
       {
        var name = $(this).attr('name');
        var id =$(this).attr('id');

        $('#nombreLista').val(name);
        $('#nombreLista').attr('idLista', id);
       }  
   

    }); 

     $(document).on("click", ".tbody1 a", function(e) {
      
       var tipo = $(this).attr('tipo'); 

       if(tipo=="eliminar")
       {   var id = $(this).attr('id');
           var idlista = $(this).attr('lista');
       
         EliminarCancion(id, idlista);

       }
        
   

    }); 
     $('#ActualizarLista').click(function()
     {
      name = $('#nombreLista').val();
      id =  $('#nombreLista').attr('idLista');

      ActualizarLista(id, name);

     });

      function ActualizarLista(id, name)
      {
        var idlista = id;
        var nombre=name;
        var accion = "EditarNombreLista";
        $.ajax({
          url:"../../php/EjecutarQuery.php?accion="+accion+"&idLista="+idlista+"&nombre="+nombre,
          data:'',
          success: function()
          {

            $('#LISTAACTUAL').html("<h4>lista: <b> " + nombre + " </b></h4>");
            $('#updateLista').modal('toggle');
              cargarListasC(); 
          }


        });

      }

    function EliminarCancion(idc, idl)
    {
        var accion ="EliminarCancion";
     
        var idcancion = idc;
        var ID= idl;

        $.ajax({
          url:"../../php/EjecutarQuery.php?accion="+accion+"&idCancion="+idcancion,
          data: '',
          success: function()
          { 
            alert("CANCION ELIMINADA CORRECTAMENTE");
            cargarListasC();            
            cargarCancionesL(ID);  
          }
      });

    }

    function EliminarListaConCanciones(id)
    {
        var accion = "EliminarListaConCanciones";
        var idLista = id;


        $.ajax({
          url:"../../php/EjecutarQuery.php?accion="+accion+"&ListaID="+idLista,
          data: '',
          success: function(a)
          {
            if(a=="1")
            {
            
              $('#LISTAACTUAL').html("<h4>lista: <b>  </b></h4>");
              cargarListasC();
              $('.tbody1').html(" ");
               alert("Tabla eliminada correctamente");
            }
            if(a=="2")
            { 
              alert("Hubo problemas al eliminar tabla");
            }
              
          }
      });

    }


    function cargarListasC()
    {
        var accion ="CanLista";

        $.ajax({
            url: "../../php/EjecutarQuery.php?accion="+accion,
            type: "json",
            success:function(s)
            {       
              lista = JSON.parse(s);        
              var  i=0;          
              var  s="";
              while(i<lista.length)
              {

                s+="<tr><td>"+ lista[i].lis_nombre +"</td>"+
                   "<td><center>"+ lista[i].cantcanciones +"</center></td>"+
                   "<td ><center><a id='"+ lista[i].id + "' tipo='mostrar' name='"+ lista[i].lis_nombre  +"'  title='DETALLES' class='btn btn-info btn-sm glyphicon glyphicon-eye-open'></a>"+
                   "<a id='"+ lista[i].id + "' tipo='editar' name='"+ lista[i].lis_nombre  +"' title='EDITAR' class='btn btn-warning btn-sm  glyphicon glyphicon-pencil'  data-toggle='modal' data-target='#updateLista' ></a>"+
                   "<a id='"+ lista[i].id + "' tipo='eliminar' name='"+ lista[i].lis_nombre  +"' title='ELIMINAR' class='btn btn-danger btn-sm glyphicon glyphicon-trash'></a></center></td></tr>"+
                   "</tr>"; 

                i++;
              }  
                $('.tbody').html(s);
            }
        });
    }
     function cargarCancionesL(as)
     {
        var accion ="mostrar";
        var idLista = as;
         var  s="";
        $.ajax({
            url:"../../php/EjecutarQuery.php?accion="+accion+"&ListaID="+idLista,
            type: "json",
            success: function(ss)
            {                 
              cancion = JSON.parse(ss);           
              var  i=0;                      

              while(i<cancion.length)
              {
                s+="<tr><td>"+ cancion[i].nombre +"</td>"+
                   "<td><center>"+ cancion[i].size +"</center></td>"+
                   "<td><center>"+              
                   "<a id='"+ cancion[i].id + "' tipo='eliminar' lista='" + cancion[i].LISTA_id + "' name='"+ cancion[i].can_titulo  +"'  title='ELIMINAR' class='btn btn-danger btn-sm glyphicon glyphicon-trash'></a></center></td></tr>"+
                   "</tr>";
                i++;
              }  
              $('.tbody1').html(" ");
             $('.tbody1').html(s);
            }
        });
     }

 /*  function archivo(e)
   {    
                  var files = e.target.files;
                  for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('audio.*')) {
                        continue;
                    }
                    var reader = new FileReader();             
                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById("nombreCancion").innerHTML = ['<label><b>',escape(theFile.name),'</b></label>'].join('');
                        };
                    })(f);
             
                    reader.readAsDataURL(f);
                  }
   }

   document.getElementById('Cancion').addEventListener('change', archivo, false);
*/
});






//initialize plyr

