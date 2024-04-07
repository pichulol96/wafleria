<?php
include("IP.php");
$objetoIP = new IP();
$ip = $objetoIP->obtenerIP();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Panel Administrativo</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
    <style>
        .icon-delete{
            width: 15px;
        }
        .imagen{
            width:200px;
            border-radius:10px;
        }
        .input{
            margin-top:10px;
            margin-bottom:10px;
        }
        #imgPreview{
            width:200px;
        }
        #editar_imgPreview{
            width:200px;
        }
        textarea {
            height: 150px;
        }
        .icon-save-categoria{
            width:40px;
            cursor: pointer;
        }
        .contenedor-categoria-hide{
            display: none;
        }
        .contenedor-editar-categoria-hide{
            display: none;
        }
        .contenedor-categoria-show{
            display: block;
        }
        .contenedor-editar-categoria-show{
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Panel Administrativo</h1>
        <div class="row">
            <div class="col-md-11">
                <input type="text" id="buscar" onkeyup="buscarComida(event)" placeholder="Buscar" class="form-control">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Nuevo
                </button>
            </div>
        </div>
        <div class="shadow p-3 mb-5 bg-body-tertiary rounded table-responsive">
        <table id="tabla" class="table table-striped table-hover">
                <thead>
                    <tr>
                    <th scope="col">Productos</th>
                    <th scope="col">Presentacion</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody id="lista_productos">
                </tbody>
        </table>
        </div>
        <!-- Modal registro -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Nuevo Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <form method="post" enctype="multipart/form-data" id ="frm-registrar">
                    <div class="row">
                      <div class="col-md-6">
                        <select class="form-control" name="categoria" id="categoria">
                        </select>
                      </div>
                      <div class="col-md-2">
                        <img onclick="showNuevaCategoria()" class="icon-save-categoria" src="/wafleria/archivos/save.svg" alt="">
                      </div>
                      <div class="col-md-2">
                        <img onclick="showEditarCategoria()" class="icon-save-categoria" src="/wafleria/archivos/editar.svg" alt="">
                      </div>
                      <div class="col-md-2">
                        <img onclick="showEliminarCategoria()" class="icon-save-categoria" src="/wafleria/archivos/icon_eliminar.svg" alt="">
                      </div>
                    </div>

                    <div id ="contenedor_categoria" class="card contenedor-categoria-hide">
                        <h5 class="card-header">Nueva categoria</h5>
                        <div class="card-body">
                            <p class="card-text">La nueva categoria a registrar no tiene que existir en la base de datos.</p>
                            <div class="row">
                                <div class="col-md-9">
                                <input type="text" class="form-control" name="nuevaCategoria" id="nuevaCategoria">
                                </div>
                                <div class="col-md-3">
                                <a href="#" onclick="saveNuevaCategoria()" class="btn btn-primary">Guardar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id ="contenedor_editar_categoria" class="card contenedor-editar-categoria-hide">
                        <h5 class="card-header">Editar categoria</h5>
                        <div class="card-body">
                            <p class="card-text">La categoria a editar no tiene que existir en la base de datos.</p>
                            <div class="row">
                                <div class="col-md-9">
                                <input type="text" class="form-control" name="editarCategoria" id="editarCategoria">
                                </div>
                                <div class="col-md-3">
                                <a href="#" onclick="saveEditarCategoria()" class="btn btn-primary">Editar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="text" name="nombre_producto" id="nombre_producto" class="form-control input" placeholder="Nombre del producto">
                    <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="10" placeholder="Descripcion/Presentacion"></textarea>
                    <input type="text" name="precio" id="precio" class="form-control input" placeholder="Precio">
                    <input type="file" onchange="renderIMG('registrar')" id="imagen" name="imagen" placeholder="Imagen" class="input">
                    </div>

                    <img id="imgPreview"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-guardar-producto" class="btn btn-primary">Guardar</button>
            </div>
            </div>
        </div>
        </div>

        <!-- Modal editar -->
        <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editarModalModalLabel">Editar registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <form method="post" enctype="multipart/form-data" id ="frm-editar">
                    <input hidden type="text" name="actual_imagen" id="actual_imagen" >
                    <input hidden type="text" name="editar_idproducto" id="editar_idproducto" >
                    <select class="form-control" name="editar_categoria" id="editar_categoria">
                    </select>
                    <input type="text" name="editar_nombre_producto" id="editar_nombre_producto" class="form-control input" placeholder="Nombre del producto">
                    <textarea class="form-control" name="editar_descripcion" id="editar_descripcion" cols="30" rows="10" placeholder="Descripcion/Presentacion"></textarea>
                    <input type="text" name="editar_precio" id="editar_precio" class="form-control input" placeholder="Precio">
                    <input type="file" onchange="renderIMG('editar')" id="editar_imagen" name="editar_imagen" placeholder="Imagen" class="input">

                    <img id="editar_imgPreview"/>
                </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-editar-producto" class="btn btn-primary">Guardar</button>
            </div>
            </div>
        </div>
        </div>

    </div>
</body>
<script>
    var contador = 0;
    var idContador =0 ;
    var productos_carrito = [];
    const data = { text: "" };
    const ip = "<?php echo $ip;?>"

    postJSON(data);
    getCategorias("categoria","");

    async function postJSON(data) {
        try {
            const response = await fetch(`http://${ip}/wafleria/productos.php`, {
            method: "POST", // or 'PUT'
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
            });

            const result = await response.json();
            productos_carrito = result;
            llenarTabla();
            console.log(result);
        } catch (error) {
            console.error("Error:", error);
        }
    }

    function llenarTabla(){
        console.log(productos_carrito);
        let lista = document.getElementById("lista_productos");
        lista.parentNode.removeChild(lista);

        var newDiv = document.createElement("tbody");
        var currentDiv = document.getElementById("tabla");
            newDiv.setAttribute("id","lista_productos");
            //newDiv.setAttribute("class","row");
            currentDiv.appendChild(newDiv);
        
        let lista_productos = document.getElementById("lista_productos");

        const resp = productos_carrito.map(function suma(obj){
            lista_productos.innerHTML +=`
            <tr>
                    <td>${obj.producto}</td>
                    <td>${obj.descripcion}</td>
                    <td><img class="imagen" src="/wafleria/archivos/${obj.img}" /></td>
                    <td class="rigth-precio">${obj.precio}</td>
                    <td class="rigth-cantidad">${obj.categorias} </td>
                    <td>
                    <button class="btn btn-success" onclick="editar_confirm('${obj.idproducto}','${obj.producto}','${obj.descripcion}','${obj.precio}','${obj.img}','${obj.categorias}')"><img class="icon-delete" src="/wafleria/archivos/pencil.svg" /></button>
                    <button class="btn btn-danger" onclick="eliminar_confirm('${obj.idproducto}','${obj.img}')"><img class="icon-delete" src="/wafleria/archivos/trash_89366.svg" /></button>
                    </td>
                    
            </tr>   
            `;

        });
    }

    async function editar_confirm(idproducto,producto,descripcion,precio,img,categoria){
        var categorias = document.querySelectorAll('#editar_categoria option');
        categorias.forEach(o => o.remove());
        getCategorias("editar_categoria",categoria);
        document.getElementById("editar_idproducto").value = idproducto;
        document.getElementById("editar_nombre_producto").value = producto;
        document.getElementById("editar_descripcion").value = descripcion;
        document.getElementById("editar_precio").value = precio;
        document.getElementById("actual_imagen").value = img;
        
        document.getElementById("editar_imagen").value= "";
        let preview =document.getElementById("editar_imgPreview");
        preview.src = `/wafleria/archivos/${img}`

        const myModal = new bootstrap.Modal('#editarModal', {
         keyboard: false
        })
        myModal.show();
    }
    async function eliminar_confirm(idproducto,imagen){
        Swal.fire({
        title: "Quieres eliminar el producto?",
        text: "El producto sera borrado de sus registro!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar"
        }).then((result) => {
        if (result.isConfirmed) {
            eliminar(idproducto,imagen)
        }
        });
    }
    async function eliminar(idproducto,imagen){
        const producto = { idproducto,imagen };
        try {
            const response = await fetch(`http://${ip}/wafleria/eliminar_producto.php`, {
            method: "POST", // or 'PUT'
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(producto),
            });

            const result = await response.json();
            if(result == "success"){
                Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Eliminado!",
                text: "El producto se elimino correctamente!",
                showConfirmButton: false,
                timer: 2500
                });
                postJSON(data)
            }
            else {
                Swal.fire({
                icon: "error",
                title: "Ocurrio algun error",
                text: "Problemas en el servidor!",
                });
            }
        } catch (error) {
            console.error("Error:", error);
        }   
    }

    async function getCategorias(idcategoria,nombre) {
        const response = await fetch(`http://${ip}/wafleria/categorias.php`);
        const movies = await response.json();
        let categorias = document.getElementById(idcategoria);
        categorias.innerHTML +=`
               <option value="">Seleccionar Categoria</option>
            `
        movies.map(function suma(obj){
            if(nombre==obj.nombre){
                categorias.innerHTML +=`
               <option value="'${obj.idcategoria}'" selected>${obj.nombre}</option>
            `
            }
            else {
                categorias.innerHTML +=`
               <option value="'${obj.idcategoria}'">${obj.nombre}</option>
            `
            }
        })
        //console.log(movies);
    }

    document.getElementById("btn-guardar-producto").addEventListener('click',async (e)=>{
        e.preventDefault();
        let frm = document.getElementById("frm-registrar");
        let formData = new FormData(frm);
        console.log(formData.get("categoria"));
        try {
            const response = await fetch(`http://${ip}/wafleria/registrar_productos.php`, {
            method: "POST", // or 'PUT'
            body: formData,
            });

            const result = await response.json();
            if(result == "success"){
                Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Guardado!",
                text: "El producto se guardo correctamente!",
                showConfirmButton: false,
                timer: 2500
                });
                frm.reset();
                document.getElementById("imgPreview").src = '';
                postJSON(data)
            }
            else {
                Swal.fire({
                icon: "error",
                title: "Ocurrio algun error",
                text: "revise que todos los datos sean correctos y no haya campos vacios!",
                });
            }
        } catch (error) {
            console.error("Error:", error);
        }
    })
    document.getElementById("btn-editar-producto").addEventListener('click',async (e)=>{
        e.preventDefault();
        let frm = document.getElementById("frm-editar");
        let formData = new FormData(frm);
        try {
            const response = await fetch(`http://${ip}/wafleria/editar_productos.php`, {
            method: "POST", // or 'PUT'
            body: formData,
            });

            const result = await response.json();
            if(result == "success"){
                const truck_modal = document.querySelector('#editarModal');
                const modal = bootstrap.Modal.getInstance(truck_modal);    
                modal.hide();
                
                Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Guardado!",
                text: "El producto se edito correctamente!",
                showConfirmButton: false,
                timer: 2500
                });
                frm.reset();
                postJSON(data);
            }
            else {
                Swal.fire({
                icon: "error",
                title: "Ocurrio algun error",
                text: "revise que todos los datos sean correctos y no haya campos vacios!",
                });
            }
        } catch (error) {
            console.error("Error:", error);
        }
    })
    function renderIMG(text){
      if(text == "editar") {
        let imagen = document.getElementById("editar_imagen").files[0];
        let preview =document.getElementById("editar_imgPreview");
        renderIMGprev(imagen,preview);
      }
      if(text == "registrar") {
        let imagen = document.getElementById("imagen").files[0];
        let preview =document.getElementById("imgPreview");
        renderIMGprev(imagen,preview);
      }
      //let imagen = document.getElementById("imagen").files[0];
    }
    function renderIMGprev(imagen,preview) {
      const reader = new FileReader();
      reader.addEventListener('load', (event) => {
       preview.src = event.target.result;
      });

        reader.readAsDataURL(imagen);
        console.log(imagen);
    }

    function buscarComida(text){
        let input = document.getElementById("buscar");
        const data = { text: input.value};
        postJSON(data);
    }
    function showNuevaCategoria(){
        document.getElementById('contenedor_categoria').classList.toggle("contenedor-categoria-hide");
    }
    async function saveNuevaCategoria(){
        nueva_categoria = document.getElementById("nuevaCategoria").value;
        if(nueva_categoria =="" || nueva_categoria == " " || nueva_categoria.length<4)
        {
            Swal.fire({
                icon: "error",
                title: "Ocurrio algun error",
                text: "No se aceptan campos vacios, ademas la categoria debe ser mayor a 3 letras",
            });
        }
        else {
            try {
            const response = await fetch(`http://${ip}/wafleria/registrar_categorias.php`, {
            method: "POST", // or 'PUT'
            body: JSON.stringify({categoria:nueva_categoria}),
            });
            const result = await response.json();
            if(result=="success") {
                //let categorias = document.getElementById("categoria");
                var categorias = document.querySelectorAll('#categoria option');
                categorias.forEach(o => o.remove());
                getCategorias("categoria","");
                Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Guardado!",
                text: "La categoria se guardo correctamente!",
                showConfirmButton: false,
                timer: 2500
                });
                document.getElementById("nuevaCategoria").value="";
                document.getElementById('contenedor_categoria').classList.toggle("contenedor-categoria-hide");

            }
            else {
                Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Error!",
                text: "Ocurrio un problema al guardar!",
                showConfirmButton: false,
                timer: 2500
                });
            }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    }
    function showEditarCategoria(){
        document.getElementById('contenedor_editar_categoria').classList.toggle("contenedor-editar-categoria-hide");
    }
    async function saveEditarCategoria(){
        let select = document.getElementById("categoria").value;  
        categoria = document.getElementById("editarCategoria").value;
        if(categoria =="" || categoria == " " || categoria.length<4)
        {
            Swal.fire({
                icon: "error",
                title: "Ocurrio algun error",
                text: "No se aceptan campos vacios, ademas la categoria debe ser mayor a 3 letras",
            });
        }
        else {
            try {
            const response = await fetch(`http://${ip}/wafleria/editar_categorias.php`, {
            method: "POST", // or 'PUT'
            body: JSON.stringify({id:select,categoria:categoria}),
            });
            const result = await response.json();
            if(result=="success") {
                //let categorias = document.getElementById("categoria");
                var categorias = document.querySelectorAll('#categoria option');
                categorias.forEach(o => o.remove());
                getCategorias("categoria","");
                Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Guardado!",
                text: "La categoria se edito correctamente!",
                showConfirmButton: false,
                timer: 2500
                });
                document.getElementById("editarCategoria").value="";
                document.getElementById('contenedor_editar_categoria').classList.toggle("contenedor-editar-categoria-hide");

            }
            else {
                Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Error!",
                text: result,
                showConfirmButton: false,
                timer: 2500
                });
            }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    }
    function showEliminarCategoria(){
        let select = document.getElementById("categoria").value;  
        if(select =="" || categoria == " ")
        {
            Swal.fire({
                icon: "error",
                title: "Ocurrio algun error",
                text: "Seleccione la categoria que desea eliminar",
            });
            return
        }
        Swal.fire({
        title: "Quieres eliminar la categoria?",
        text: "La categoria sera borrada de sus registro!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar"
        }).then((result) => {
        if (result.isConfirmed) {
            eliminarCategoria(select)
        }
        });
    }
    async function eliminarCategoria(id){
        try {
            const response = await fetch(`http://${ip}/wafleria/eliminar_categorias.php`, {
            method: "POST", // or 'PUT'
            body: JSON.stringify({idcategoria:id}),
            });
            const result = await response.json();
            if(result=="success") {
                //let categorias = document.getElementById("categoria");
                var categorias = document.querySelectorAll('#categoria option');
                categorias.forEach(o => o.remove());
                getCategorias("categoria","");
                Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Guardado!",
                text: "La categoria se elimino correctamente!",
                showConfirmButton: false,
                timer: 2500
                });

            }
            else {
                Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Error!",
                text: result,
                showConfirmButton: false,
                timer: 2500
                });
            }
            } catch (error) {
                console.error("Error:", error);
            }
    }
</script>
</html>