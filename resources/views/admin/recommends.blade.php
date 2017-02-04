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

          <h2 class="sub-header">推荐管理</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>推荐内容</th>
                  <th>已完成</th>
                  <th>发布时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($recommends as $recommend)
                    <tr>
                      <td>{{ $recommend->id }}</td>
                      <td>{{ $recommend->name }}</td>
                      <td><a href="finishedlist?id={{ $recommend->id }}" target="_blank">{{ $recommend->finished_users()->count() }}</a></td>
                      <td>{{ $recommend->created_at }}</td>
                      <td><a href="delrecommend?id={{ $recommend->id }}" class="btn btn-link">删除</a></td>
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

    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  </body>
</html>

