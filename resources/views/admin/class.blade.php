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

          <h2 class="sub-header">组织结构</h2>
          <div class="table-responsive">
           
           <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{$classes[0]}}</th>
                  <th>{{$classes[1]}}</th>
                  <th>{{$classes[2]}}</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody id="list">

              </tbody>
            </table>

           <div class="col-md-2 margin-bottom-15">
                    <input type="text" class="form-control" id="c1" placeholder="{{$classes[0]}}">  
                </div>

                <div class="col-md-2 margin-bottom-15">
                    <input type="text" class="form-control" id="c2" placeholder="{{$classes[1]}}">  
                </div>

                <div class="col-md-2 margin-bottom-15">
                    <input type="text" class="form-control" id="c3" placeholder="{{$classes[2]}}">
                </div>

                <div class="col-md-1 margin-bottom-15">
                   <button type="submit" class="btn btn-primary" id="add">插入</button>
                </div>

                <div class="col-md-1 margin-bottom-15">
                   <form action="settings" method="post">
                 <input id="list_json" type="hidden" name="class_list"> 
                  <button type="submit" class="btn btn-primary">保存</button>
                {!! csrf_field() !!}       
                </form>
                </div>

                 

          </div>
        </div>
      </div>
    </div>

    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

    <script>
            var list = []; 
            var c1_max_num = 0;
            var c2_max_num = 0;
            var c3_max_num = 0;

            function pad(num, n) {  
                var len = num.toString().length;  
                while(len < n) {  
                    num = "0" + num;  
                    len++;  
                }  
                return num;  
            }

            Array.prototype.remove=function(dx)
          　{
          　　if(isNaN(dx)||dx>this.length){return false;}
          　　for(var i=0,n=0;i<this.length;i++)
          　　{
          　　　　if(this[i]!=this[dx])
          　　　　{
          　　　　　　this[n++]=this[i]
          　　　　}
          　　}
          　　this.length-=1
          　}



            function delItem(code){
              di = -1;
              $.each(list,function(i,value) {
                if(code == value['code']){
                  di = i;
                }
              });
              if(di>=0){
                list.remove(di);
              }
              updateList();
            }



            function updateList(){
              $("#list_json").val(JSON.stringify(list));

              $.each(list,function(i,value) {
                code = value['code'];
                name = value['name'];
                c1_num = Number(code.substr(0, 2));
                c2_num = Number(code.substr(2, 2));
                c3_num = Number(code.substr(4, 2));
                c1_max_num = c1_num>c1_max_num ? c1_num : c1_max_num;
                c2_max_num = c2_num>c2_max_num ? c2_num : c2_max_num;
                c3_max_num = c3_num>c3_max_num ? c3_num : c3_max_num;
              });

              $("#list").html('');

              $.each(list,function(i,value) {
                code = value['code'];
                name = value['name'];
                c1_code = code.substr(0, 2);
                c2_code = code.substr(2, 2);
                c3_code = code.substr(4, 2);
                c1_name = '';
                c2_name = '';
                c3_name = '';

                if(c2_code != '00' && c3_code != '00'){
                c3_name = name;

                $.each(list,function(i,value) {
                  if(value['code'] == c1_code + '0000'){
                    c1_name = value['name'];
                  }

                  if(value['code'] == c1_code + c2_code + '00'){
                    c2_name = value['name'];
                  }
                });

                $("#list").append('<tr><td>'+ value.code + '</td><td>' + c1_name +'</td><td>'+ c2_name +'</td><td>' + c3_name + '</td><td><a onclick="delItem(\''+ value.code +'\')" href="#">删除</a></td></tr>');
              };
            });
          }

            list = jQuery.parseJSON('<?php echo $setting->content ?>');
            updateList();


            $("#add").click(function(){
              c1_name = $("#c1").val();
              c2_name = $("#c2").val();
              c3_name = $("#c3").val();

              c1_code = '';
              c2_code = '';
              c3_code = '';
              
              $.each(list,function(i,value) {
                code = value['code'];
                name = value['name'];
                if(c1_name == name){
                  c1_code = code.substr(0, 2);
                }
                if(c2_name == name && c1_code == code.substr(0, 2)){
                  c2_code = code.substr(2, 2);
                }
              });

              if(c1_code == '' && c1_name.length>0){
                c1_code = pad((c1_max_num+1),2);
                list.push({'code':c1_code + '0000','name':c1_name});
              }

              if(c2_code == '' && c1_name.length>0 && c2_name.length>0){
                c2_code = pad((c2_max_num+1),2);
                list.push({'code':c1_code + c2_code + '00','name':c2_name});
              }

              if(c1_name.length>0 && c2_name.length>0 && c3_name.length>0){
                c3_code = pad((c3_max_num+1),2);
                list.push({'code':c1_code + c2_code + c3_code,'name':c3_name});
              }

              //list = jQuery.parseJSON($(this).val());

              $("#c3").val('');

              //$("#list_json").val(JSON.stringify(list));
              console.log(list);
              updateList();
            });


          </script>

  </body>
</html>

