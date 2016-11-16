<html ng-app="ionicApp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>首页</title>
    <link href="css/ionic.min.css" rel="stylesheet">
    <script src="js/ionic.bundle.min.js"></script>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="http://www.yun-li.com/wx/js.config.php"></script>
    <script src="js/main.js"></script>

    <style>
    ion-content {
        background: url(img/bg.png) no-repeat center;
        background-size: cover;
    }
    </style>
</head>

<body>
    <!--<ion-nav-bar class="bar-positive">
      <ion-nav-back-button>
      </ion-nav-back-button>
    </ion-nav-bar>-->
    <ion-nav-view></ion-nav-view>
    <script id="templates/tabs.html" type="text/ng-template">
        <ion-tabs class="tabs-icon-top" ng-controller="InitController">
            <ion-tab title="首页" icon="ion-home" href="#/tab/home">
                <ion-nav-view name="home-tab"></ion-nav-view>
            </ion-tab>
            <ion-tab title="找书" icon="ion-ios-book" href="#/tab/search">
                <ion-nav-view name="search-tab"></ion-nav-view>
            </ion-tab>
            <ion-tab title="我的" icon="ion-ios-person" href="#/tab/user">
                <ion-nav-view name="user-tab"></ion-nav-view>
            </ion-tab>
        </ion-tabs>
    </script>
    <script id="templates/home.html" type="text/ng-template">
        <ion-view view-title="首页" ng-controller="HomeController">
            <ion-content class="padding">
                <button id="scanQRCode" class="button icon-left ion-ios-barcode-outline button-block button-positive">漂流扫码</button>
                <div class="list card" id="page2-card24">
                    <div class=" item item-image">
                        <img src="img/banner.jpg" width="100%" height="200px" style="display: block; margin-left: auto; margin-right: auto;">
                    </div>
                    <ion-item class="item-divider item" id="page2-list-item-divider4"> 最新动态</ion-item>
                    <ion-list class="disable-user-behavior">
                        <div class="list">
                            <ion-item class="item" href="#article/@{{article.id}}" ng-repeat="article in home.articles">@{{article.title}}</ion-item>
                            <ion-item class="item-divider item" id="page2-list-item-divider3"> 推荐书目</ion-item>
                            <ion-item href="#/tab/search?keywords=@{{recommend.name}}" ng-repeat="recommend in home.recommends">@{{recommend.name}}</ion-item>
                        </div>
                    </ion-list>
                </div>
            </ion-content>
        </ion-view>
    </script>

    <script id="templates/search.html" type="text/ng-template">
        <ion-view view-title="找书" ng-controller="ItemsController">
            <div class="bar bar-header item-input-inset" style="opacity:0.9">
                <label class="item-input-wrapper">
                    <i class="icon ion-ios-search placeholder-icon"></i>
                    <input id="keywords" type="search" placeholder="图书名称" ng-model="keywords">
                </label>
                <button class="button button-positive" ng-click="search()">
                    搜索
                </button>
            </div>
            <ion-content style="padding-top:44px">
                <ion-list>
                    <a class="item item-thumbnail-left" href="#/item/@{{item.id}}" ng-repeat="item in items">
                        <img ng-src="@{{item.photo}}">
                        <h2>@{{item.name}}</h2>
                        <p>@{{item.des}}</p>
                    </a>
                </ion-list>
                <ion-infinite-scroll on-infinite="loadMore()" ng-if="canLoad" distance="1%"> </ion-infinite-scroll>
            </ion-content>
        </ion-view>
    </script>

    <script id="templates/articles.html" type="text/ng-template">
        <ion-view view-title="文章列表" ng-controller="ArticlesController">
            <ion-content>

            <div class="list" >

              <a class="item" href="#/article/@{{article.id}}" ng-repeat="article in articles">
                @{{article.title}}
              </a>
            </div>


            </ion-content>
        </ion-view>
    </script>

    <script id="templates/article.html" type="text/ng-template">
        <ion-view view-title="文章" ng-controller="ArticleController">
            <div class="bar bar-header bar-light">
                <h1 class="title">@{{article.title}}</h1>
            </div>
            <ion-content>
                <div class="card" style="margin-top: 60px;">
                    <div class="item item-text-wrap">
                        @{{article.content}}
                         <a href="#" class="subdued">@@{{article.user_name}}</a>
                    </div>
                </div>
            </ion-content>
        </ion-view>
    </script>
    <script id="templates/item.html" type="text/ng-template">
        <ion-view view-title="Item" ng-controller="ItemController">
         <ion-content class="padding">
            <ion-list class="list">
                <div class="list">
                    <ion-item class="item-thumbnail-left item">
                        <img ng-src="@{{item.photo}}">
                        <h2>@{{item.name}}</h2>
                        <p> 主人：@{{item.user_name}}</p>
                        <p> 有效期：@{{item.date}}</p>
                    </ion-item>
                </div>
            </ion-list>
            <div class="item item-body">
                <div>
                    <p>@{{item.des}}</p>
                </div>
            </div>
            <ion-list>
                <div class="list">
                    <ion-item class="item-divider item"> 读书心得</ion-item>
                    <ion-list>
                        <div class="list" ng-repeat="article in item.articles">
                            <ion-item class="item" href="#article/@{{article.id}}">@{{article.title}}</ion-item>
                        </div>
                    </ion-list>
                    <ion-item class="item-divider item"> 漂流记录</ion-item>

                     <ion-list ng-repeat="transfer in transfers">
                        <div class="item"><p><strong>@{{transfer.time}}</strong> @{{transfer.from.name}} → @{{transfer.to.name}}</p></div>
                    </ion-list>

                </div>
            </ion-list>
          
            <button class="button button-positive  button-block" ng-click="request()">申请借书</button>

             <div class="button-bar bar-clear">
           <a class="button button-clear button-positive" href="#/post/@{{item.id}}">分享心得</a>
           <a class="button button-clear button-positive" ng-click="reTime()">刷新漂流时间</a>
           </div>

             </ion-content>
        </ion-view>
    </script>
    <script id="templates/user_info.html" type="text/ng-template">
        <ion-view view-title="用户信息" ng-controller="UserInfoController">
            <ion-content class="padding">
                <div class="list list-inset">
                    <label class="item item-input">
                        <input id="name" ng-model="user.name" type="text" placeholder="名字">
                    </label>

   <div class="item item-input item-select">

    <div class="input-label">
      学校
    </div>
    <select ng-model="class.c1.code" ng-change="classChange()" ng-options="c1.code as c1.name for c1 in class.list.c1">
    </select>
  </div>

   <div class="item item-input item-select">

    <div class="input-label">
      年级
    </div>
    <select ng-model="class.c2.code" ng-change="classChange()" ng-options="c2.code as c2.name for c2 in class.list.c2">
    </select>
  </div>

     <div class="item item-input item-select">

    <div class="input-label">
      班级
    </div>
    <select ng-model="class.c3.code" ng-change="classChange()" ng-options="c3.code as c3.name for c3 in class.list.c3">
    </select>
  </div>



           <!--          <label class="item item-input">
                        <input id="class" ng-model="user.class" type="text" placeholder="班级">
                    </label> -->
                    <label class="item item-input">
                        <input id="email" ng-model="user.email" type="text" placeholder="邮箱">
                    </label>
                    <label class="item item-input">
                        <input id="contact" ng-model="user.contact" type="text" placeholder="联系方式">
                    </label>
                </div>
                <button class="button button-block button-positive" ng-click="submit()">确定</button>
            </ion-content>
        </ion-view>
    </script>
    <script id="templates/search.html" type="text/ng-template">
        <ion-view view-title="找书" ng-controller="ItemsController">
            <div class="bar bar-header item-input-inset" style="opacity:0.9">
                <label class="item-input-wrapper">
                    <i class="icon ion-ios-search placeholder-icon"></i>
                    <input id="keywords" type="search" placeholder="图书名称" ng-model="keywords">
                </label>
                <button class="button button-positive" ng-click="search()">
                    搜索
                </button>
            </div>
            <ion-content style="padding-top:44px">
                <ion-list>
                    <a class="item item-thumbnail-left" href="#/item/@{{item.id}}" ng-repeat="item in items">
                        <img ng-src="@{{item.photo}}">
                        <h2>@{{item.name}}</h2>
                        <p>@{{item.des}}</p>
                    </a>
                </ion-list>
                <ion-infinite-scroll on-infinite="loadMore()" ng-if="canLoad" distance="1%"> </ion-infinite-scroll>
            </ion-content>
        </ion-view>
    </script>
    <script id="templates/item_edit.html" type="text/ng-template">
        <ion-view view-title="编辑" ng-controller="EditController">
            <ion-content class="padding">
                <div>
                    <form class="list ng-pristine ng-valid">
                        <label class="item item-input">
                            <span class="input-label" aria-label="书名">书名</span>
                            <input id="name" ng-model="item.name" type="text" placeholder="">
                        </label>
                        <div onclick="file.click()" style="margin: 0px;  background-color: rgb(232, 235, 239); text-align: center;">
                            <img id="photo" width="100%" ng-src="img/picture.png" style="color: rgb(136, 136, 136); vertical-align: middle;" />
                        </div>
                        <!-- <label class="item item-select" id="page7-select1">
                            <span class="input-label" aria-label="漂流时间" id="_label-2">漂流时间</span>
                            <select>
                                <option value="1个月">1个月</option>
                            </select>
                        </label> -->
                        <label class="item item-input">
                            <span class="input-label" aria-label="介绍">介绍</span>
                            <input id="des" ng-model="item.des" type="text" placeholder="">
                        </label>
   

                             <ion-toggle ng-model="item.transfer">允许多次漂流</ion-toggle>
        
                         <!-- <input type="text" ng-model="item.photo" id="img" style="display: none;"/> -->
                        <button id="submit" class="button button-positive  button-block" ng-click="submit()">发布</button>
                    </form>

                    <input type="file" ng-model="item.file" id="file" onchange="readFile(this)" style="visibility: hidden; position: absolute;" />
                        

                </div>
            </ion-content>
        </ion-view>
    </script>
    <script id="templates/user.html" type="text/ng-template">
        <ion-view title="用户" ng-controller="UserController">
            <ion-content class="padding">
            <a ng-show="hasRequest" class="button button-stable button-small button-block icon-left ion-android-notifications" href="#/request">查看借阅申请</a>
                <div class="list card">
                

                    <ion-item class="item-avatar positive item item-complex" href="#/user_info">
                        <img src="@{{gravatar}}" />
                        <h2positive>@{{user.name}}
                            <p>@{{user.class}}</p>
                            <p>@{{user.contact}}</p>
                        </h2positive>
                    </ion-item>
                    <ion-item class="item-icon-left item">
                        <i class="icon ion-android-star"></i>已经获得 @{{user.star}} 颗星</ion-item>
                    <ion-item class="item-icon-left item item-complex" href="#/tab/search?user=@{{user.id}}">
                        <i class="icon ion-ios-book"></i>岛内有 @{{user.item_num}} 本书</ion-item>
                    <ion-item class="item-icon-left item" href="#/articles/@{{user.id}}">
                        <i class="icon ion-ios-bookmarks"></i>发布了 @{{user.article_num}} 篇读书心得</ion-item>

                </div>
                <a href="#/item_edit" class="button icon-left ion-android-add-circle button-block button-positive">发布图书</a>
                <a class="button button-positive  button-block button-clear" href="javascript:location.reload()">刷新</a>
            </ion-content>
        </ion-view>
    </script>

     <script id="templates/post.html" type="text/ng-template">
        <ion-view title="编辑文章" ng-controller="PostController">
            <ion-content class="padding">
            <div class="list">
            <ion-item class="item item-input"><input type="text" placeholder="文章标题" ng-model="item.title"></ion-item>
            <ion-item class="item item-input"><textarea style="height: 80%" placeholder="正文" ng-model="item.content"></textarea></ion-item>    
              
             <button class="button button-block button-positive" ng-click="submit()">发表</button>
            </div>
            </ion-content>
        </ion-view>
    </script>

     <script id="templates/request.html" type="text/ng-template">
        <ion-view title="编辑文章" ng-controller="RequestController">
            <div class="list">
                <a class="item" ng-repeat="request in requests" ng-click="showPopup(@{{request.id}})">
                  <!-- <img src="venkman.jpg"> -->
                  <h2><strong>@{{request.item.name}}</strong></h2>
                  <p>@{{request.from_user.class}}@{{request.from_user.name}}→@{{request.to_user.class}}@{{request.to_user.name}}</p>
                  <p>有效期：@{{request.item.htime}} 交付方式:@{{request.trans_way}}</p>
                </a>
            </div>
        </ion-view>
    </script>

</body>

</html>
