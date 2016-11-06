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

          <li class="active"><a href="articles"><i class="fa fa-cubes"></i>文章管理</a></li>
          <li><a href="recommends"><i class="fa fa-cubes"></i>推荐管理</a></li>
          <!-- <li class="active"><a href="#"><i class="fa fa-users"></i>用户管理</a></li> -->
          <li><a href="settings"><i class="fa fa-cog"></i>系统设置</a></li>
          <li><a href="logout" data-toggle="modal" data-target="#confirmModal"><i class="fa fa-sign-out"></i>退出</a></li>
        </ul>
      </div><!--/.navbar-collapse -->


      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <ol class="breadcrumb">
            <li><a href="#">管理系统</a></li>
            <li><a href="articles">文章管理</a></li>
            <li class="active">发布文章</li>
          </ol>

          <form role="form" id="templatemo-preferences-form" action="newarticle" method="POST">
               
                <div class="row">
                  <div class="col-md-12 margin-bottom-15">
                    <label for="password_1">标题</label>
                    <input type="text" class="form-control" name="title" placeholder="">  
                  </div>
                </div>
                

              <div class="row">
                <div class="col-md-12 margin-bottom-15">
                  <label for="notes">内容</label>
                  <textarea class="form-control" rows="15" name="content"></textarea>
                </div>
              </div>
            
              <div class="row templatemo-form-buttons">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary">发布</button>
                  <button type="reset" class="btn btn-default">取消</button>    
                </div>
              </div>
              {!! csrf_field() !!}
            </form>

        </div>
      </div>



      <!-- Modal -->
      <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Are you sure you want to sign out?</h4>
            </div>
            <div class="modal-footer">
              <a href="sign-in.html" class="btn btn-primary">Yes</a>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
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