<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
  <title>漂流系统后台</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width">        
  <link rel="stylesheet" href="../css/templatemo_main.css">
</head>
<body>
  <div id="main-wrapper">
    <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logo"><h1>漂流系统后台</h1></div>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button> 
      </div>   
    </div>
    <div class="template-page-wrapper">
      <div class="navbar-collapse collapse templatemo-sidebar">
        <ul class="templatemo-sidebar-menu">
          <li>
            <form class="navbar-form" style="display:none">
              <input type="text" class="form-control" id="templatemo_search_box" placeholder="Search...">
              <span class="btn btn-default">Go</span>
            </form>
          </li>
           <li><a href="items"><i class="fa fa-cubes"></i>项目管理</a></li>

          <li><a href="articles"><i class="fa fa-cubes"></i>文章管理</a></li>
          <li class="active"><a href="recommends"><i class="fa fa-cubes"></i>推荐管理</a></li>
          <!-- <li class="active"><a href="#"><i class="fa fa-users"></i>用户管理</a></li> -->
          <li><a href="settings"><i class="fa fa-cog"></i>系统设置</a></li>
          <li><a href="logout" data-toggle="modal" data-target="#confirmModal"><i class="fa fa-sign-out"></i>退出</a></li>
        </ul>
      </div><!--/.navbar-collapse -->

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <ol class="breadcrumb">
            <li><a href="index.html">管理系统</a></li>
            <li class="active">推荐管理</li>
          </ol>

          <div class="row">
            <div class="col-md-12">
             
              <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                  <thead>
                  
                    <tr>
                      <th>#</th>
                      <th>推荐名称</th>
                      <th>已完成用户</th>
                      <th>发布时间</th>
                      <th>删除</th>
                    </tr>
                  
                  </thead>
                  <tbody>
                  @foreach ($recommends as $recommend)
                    <tr>
                      <td>{{ $recommend->id }}</td>
                      <td>{{ $recommend->name }}</td>
                      <td><a href="finishedlist?id={{ $recommend->id }}" target="_blank">{{ $recommend->finished_users()->count() }}</a></td>
                      <td>{{ $recommend->created_at }}</td>
                      <td><a href="delrecommend?id={{ $recommend->id }}" class="btn btn-link">Delete</a></td>
                    </tr>
                  @endforeach           
                          
                  </tbody>
                </table>

                <form action="recommends" method="post">
                <div class="col-md-2 margin-bottom-15">
                    <input type="text" class="form-control" name="name" placeholder="推荐关键词">  
                </div>

                <div class="col-md-1">
                   <button type="submit" class="btn btn-primary">添加</button>
                </div>
                    {!! csrf_field() !!}
                </form>
                
              </div>
            
            </div>
          </div>
        </div>
      </div>

      <footer class="templatemo-footer">
        <div class="templatemo-copyright">
          <p>Copyright &copy; </p>
        </div>
      </footer>
    </div>
</div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/templatemo_script.js"></script>
  </body>
</html>