angular.module('app.routes', ['ionicUIRouter'])

.config(function($stateProvider, $urlRouterProvider) {

  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider
    
  

      .state('tabsController.page2', {
    url: '/home',
    views: {
      'tab1': {
        templateUrl: 'templates/page2.html',
        controller: 'page2Ctrl'
      }
    }
  })

  .state('tabsController.page3', {
    url: '/items',
    views: {
      'tab2': {
        templateUrl: 'templates/page3.html',
        controller: 'page3Ctrl'
      }
    }
  })

  .state('tabsController.page4', {
    url: '/my',
    views: {
      'tab3': {
        templateUrl: 'templates/page4.html',
        controller: 'page4Ctrl'
      }
    }
  })

  .state('tabsController', {
    url: '/page1',
    templateUrl: 'templates/tabsController.html',
    abstract:true
  })

  .state('tabsController.page5', {
    url: '/sign-up',
    views: {
      'tab3': {
        templateUrl: 'templates/page5.html',
        controller: 'page5Ctrl'
      }
    }
  })

  /* 
    The IonicUIRouter.js UI-Router Modification is being used for this route.
    To navigate to this route, do NOT use a URL. Instead use one of the following:
      1) Using the ui-sref HTML attribute:
        ui-sref='tabsController.page6'
      2) Using $state.go programatically:
        $state.go('tabsController.page6');
    This allows your app to figure out which Tab to open this page in on the fly.
    If you're setting a Tabs default page or modifying the .otherwise for your app and
    must use a URL, use one of the following:
      /page1/tab1/items/info
      /page1/tab3/items/info
  */
  .state('tabsController.page6', {
    url: '/items/info',
    views: {
      'tab1': {
        templateUrl: 'templates/page6.html',
        controller: 'page6Ctrl'
      },
      'tab3': {
        templateUrl: 'templates/page6.html',
        controller: 'page6Ctrl'
      }
    }
  })

  .state('tabsController.page7', {
    url: '/items/create',
    views: {
      'tab3': {
        templateUrl: 'templates/page7.html',
        controller: 'page7Ctrl'
      }
    }
  })

  .state('tabsController.page8', {
    url: '/items/my',
    views: {
      'tab3': {
        templateUrl: 'templates/page8.html',
        controller: 'page8Ctrl'
      }
    }
  })

  .state('page9', {
    url: '/borrow',
    templateUrl: 'templates/page9.html',
    controller: 'page9Ctrl'
  })

  .state('tabsController.page10', {
    url: '/request',
    views: {
      'tab3': {
        templateUrl: 'templates/page10.html',
        controller: 'page10Ctrl'
      }
    }
  })

  .state('tabsController.page11', {
    url: '/articles',
    views: {
      'tab3': {
        templateUrl: 'templates/page11.html',
        controller: 'page11Ctrl'
      }
    }
  })

  /* 
    The IonicUIRouter.js UI-Router Modification is being used for this route.
    To navigate to this route, do NOT use a URL. Instead use one of the following:
      1) Using the ui-sref HTML attribute:
        ui-sref='tabsController.page12'
      2) Using $state.go programatically:
        $state.go('tabsController.page12');
    This allows your app to figure out which Tab to open this page in on the fly.
    If you're setting a Tabs default page or modifying the .otherwise for your app and
    must use a URL, use one of the following:
      /page1/tab1/article
      /page1/tab3/article
  */
  .state('tabsController.page12', {
    url: '/article/:id',
    views: {
      'tab1': {
        templateUrl: 'templates/page12.html',
        controller: 'page12Ctrl'
      },
      'tab3': {
        templateUrl: 'templates/page12.html',
        controller: 'page12Ctrl'
      }
    }
  })

$urlRouterProvider.otherwise('/page1/home')

  

});