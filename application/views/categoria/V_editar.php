<nav class="blue-grey lighten-1" style="padding: 0 1em;">
    <div class="nav-wrapper">
      <div class="col s12">
        <a href="#!" class="breadcrumb">Seguridad</a>
        <a href="#!" class="breadcrumb">Categorias</a>
        <a href="#!" class="breadcrumb">Editar</a>
      </div>
    </div>
</nav>
<div class="section container center">
    <form action="<?= base_url() ?>categoria/<?= $categoria->CATEGO_N_ID ?>/actualizar" method="post">
        <div class="row">
            <div class="input-field col s12 m6 l4">
                <input id="username" type="text" name="username" value="<?= $categoria->CATEGO_C_DESCRIPCION ?>" class="validate">
                <label class="active" for="username">Descripcion</label> 
            </div>
            <div class="input-field col s12">
                <input class="btn-large" type="submit" value="Guardar">
            </div>
        </div>
    </form>
</div>
        
