<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>漂流管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">漂流管理系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout">退出</a></li>
          </ul>
          <!-- <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form> -->
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="items">物品管理</a></li>
            <li><a href="users">用户管理</a></li>
            <li><a href="articles">文章管理</a></li>
            <li><a href="recommends">推荐管理</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="settings">系统设置</a></li>
            <li><a href="class">组织结构</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          <h2 class="sub-header">物品管理<span class="btn pull-right" id="printBtn">打印</span></h2>
          
          <div class="table-responsive">
            <table id="print" class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>名称</th>
                  <th>用户</th>
                  <th>发布时间</th>
                  <th>二维码</th>
                  <th class="ctrl">操作</th>
                </tr>
              </thead>
              <tbody>
                 @foreach ($items as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->name }}</td>
                      <td>
                      <strong>{{ $item->user->name }}</strong>
                      <p>{{ $item->user->class }}<br>{{ $item->user->contact }}</p>
                      </td>
                      <td>{{ $item->created_at }}</td>
                      <td><img width="100px" src="http://qr.liantu.com/api.php?text={{ $item->code }}"></td>
                      <td class="ctrl">
                        <a href="putitem?id={{ $item->id }}" class="btn btn-link">{{ $item->shelves ? '已上架' : '已下架' }}</a>
                        <a href="delitem?id={{ $item->id }}" class="btn btn-link">删除</a>
                      </td>
                    </tr>
                  @endforeach           
              </tbody>
            </table>
            <div class="center">{!! $items->links() !!}</div>
         
        </div>

        
        </div>

        </div>
        
      </div>
    </div>

    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="http://cdn.bootcss.com/jQuery.print/1.5.0/jQuery.print.min.js"></script>
    <script>
      $("#printBtn").click(function(){
        $(".ctrl").hide();
        $("#print").print();
        $(".ctrl").show();
      });
    </script>
  </body>
</html>
