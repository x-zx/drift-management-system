var keywords = '';
var show_user_items = 0;
var app = angular.module('ionicApp', ['ionic']);
var page = 1;
var out = null;
var code = '';
var openid = '';
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



wx.ready(function () {
document.querySelector('#scanQRCode').onclick = function () {
    wx.scanQRCode({
      needResult: 1,
      desc: 'scanQRCode desc',
      success: function (res) {
      	code = res.resultStr;//res.resultStr.split(',')[1];
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	            json = xmlhttp.responseText;
	            data = eval( "(" + json + ")" );
	            alert(data.msg);
	        }
    	}
    	xmlhttp.open("GET", 'transfer/code?code=' + code, true);
    	xmlhttp.send();
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
                }
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

        $urlRouterProvider.otherwise("/tab/home");

    });

    app.controller('InitController', function($scope, $location, $http) {

        if ($location.search().openid) {
            setOpenid($location.search().openid);
        }

        $http.get('user?openid=' + openid).success(function(data) {
            user = data;
            if(!user.id){
              $location.url('user_info');
            }
        });

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
                $location.url('/tab/user');
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
      
        $http.get('user').success(function(data){
            $scope.user = data;
        })

        $scope.submit = function() {
            $http.post('user/update', {
                openid:$scope.user.openid,
                name:$scope.user.name,
                class:$scope.user.class,
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

    app.controller('RequestController', function($scope, $location, $stateParams, $http) {
    	$scope.requests = [];
    	 $http.get('transfer/request').success(function(data){
            $scope.requests = data;
        })
    });



// function GetQueryString(name) {
//     var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
//     var r = window.location.search.substr(1).match(reg);
//     if (r != null) return unescape(r[2]);
//     return null;
// }
// function file_change(_file){
//     var file = _file.files[0]; 
//         var r = new FileReader(); 
//         r.readAsDataURL(file); 
//         $(r).on('load',function() { 
//             $.post("upload.php",
//             {
//                 data:this.result,
//             },
//             function(data,status){
//                 json = jQuery.parseJSON(data);
//                 $("#photo").attr("src",json.url);
//                 //alert(json.code);
//             });          
//     }) 
// }
