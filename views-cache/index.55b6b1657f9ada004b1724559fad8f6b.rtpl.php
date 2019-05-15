<?php if(!class_exists('Rain\Tpl')){exit;}?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Painel Administrativo
        <small>Resumo do blog</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="/admin"><i class="fa fa-dashboard"></i>Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

       <!-- Small boxes (Stat box) -->
       <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>0</h3>

              <p>Postagens</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper"></i>
            </div>
            <a href="/admin/posts" class="small-box-footer">Ver todas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>0</h3>

              <p>Categorias</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-list"></i>
            </div>
            <a href="/admin/categories" class="small-box-footer">Ver todas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>0</h3>

              <p>Usuários</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="/admin/users" class="small-box-footer">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>0</h3>

              <p>Comentários</p>
            </div>
            <div class="icon">
              <i class="ion ion-chatboxes"></i>
            </div>
            <a href="/admin/comments" class="small-box-footer">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <section class="content-header">
            <h1>
                Últimas Postagens
            </h1>
        </section>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="/admin/posts/create" class="btn btn-success">Cadastrar Postagem</a>
                    
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>Título</th>
                            <th>Data</th>
                            <th style="width: 100px">Status</th>
                            <th style="width: 140px">&nbsp;</th>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="/admin/posts/#" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar</a>
                                <a href="/admin/posts/#/delete" onclick="return confirm('Deseja realmente excluir este registro?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</a>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    </section>
    <!-- /.content -->
  