  


<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# githubog: http://ogp.me/ns/fb/githubog#">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>jQuery-Timepicker-Addon/jquery-ui-sliderAccess.js at master · trentrichardson/jQuery-Timepicker-Addon · GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-144.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144.png" />
    <link rel="logo" type="image/svg" href="http://github-media-downloads.s3.amazonaws.com/github-logo.svg" />
    <link rel="assets" href="https://a248.e.akamai.net/assets.github.com/">
    <link rel="xhr-socket" href="/_sockets" />
    


    <meta name="msapplication-TileImage" content="/windows-tile.png" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="selected-link" value="repo_source" data-pjax-transient />
    <meta content="collector.githubapp.com" name="octolytics-host" /><meta content="github" name="octolytics-app-id" />

    
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />

    <meta content="authenticity_token" name="csrf-param" />
<meta content="tKUblpZDYiVbwtZOi0FL57cREM9Rii1jmz+Og7RuUUQ=" name="csrf-token" />

    <link href="https://a248.e.akamai.net/assets.github.com/assets/github-a4c524f2138ecc4dd5bf9b8a6b1517bf38aa7b65.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://a248.e.akamai.net/assets.github.com/assets/github2-d2a693e8a6a75b6cde3420333a9e70bd2a2e20a4.css" media="all" rel="stylesheet" type="text/css" />
    


      <script src="https://a248.e.akamai.net/assets.github.com/assets/frameworks-5c60c478b1e0f90d149f11ed15aa52edd2996882.js" type="text/javascript"></script>
      <script src="https://a248.e.akamai.net/assets.github.com/assets/github-dca362d39ce6c15fd1d471169cd12026ca7ff8cc.js" type="text/javascript"></script>
      
      <meta http-equiv="x-pjax-version" content="4f7f9c630bd61e5b628d7029fe05b824">

        <link data-pjax-transient rel='permalink' href='/trentrichardson/jQuery-Timepicker-Addon/blob/ce3acd87971f04be08c0a7c2cbb18a25acf891c0/jquery-ui-sliderAccess.js'>
    <meta property="og:title" content="jQuery-Timepicker-Addon"/>
    <meta property="og:type" content="githubog:gitrepository"/>
    <meta property="og:url" content="https://github.com/trentrichardson/jQuery-Timepicker-Addon"/>
    <meta property="og:image" content="https://secure.gravatar.com/avatar/ab4c8036b1eb49d51feac4ab23975c91?s=420&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png"/>
    <meta property="og:site_name" content="GitHub"/>
    <meta property="og:description" content="jQuery-Timepicker-Addon - Adds a timepicker to jQueryUI Datepicker"/>
    <meta property="twitter:card" content="summary"/>
    <meta property="twitter:site" content="@GitHub">
    <meta property="twitter:title" content="trentrichardson/jQuery-Timepicker-Addon"/>

    <meta name="description" content="jQuery-Timepicker-Addon - Adds a timepicker to jQueryUI Datepicker" />


    <meta content="313144" name="octolytics-dimension-user_id" /><meta content="trentrichardson" name="octolytics-dimension-user_login" /><meta content="753297" name="octolytics-dimension-repository_id" /><meta content="trentrichardson/jQuery-Timepicker-Addon" name="octolytics-dimension-repository_nwo" /><meta content="true" name="octolytics-dimension-repository_public" /><meta content="false" name="octolytics-dimension-repository_is_fork" /><meta content="753297" name="octolytics-dimension-repository_network_root_id" /><meta content="trentrichardson/jQuery-Timepicker-Addon" name="octolytics-dimension-repository_network_root_nwo" />
  <link href="https://github.com/trentrichardson/jQuery-Timepicker-Addon/commits/master.atom" rel="alternate" title="Recent Commits to jQuery-Timepicker-Addon:master" type="application/atom+xml" />

  </head>


  <body class="logged_out page-blob linux vis-public env-production  ">
    <div id="wrapper">

      
      
      

      
      <div class="header header-logged-out">
  <div class="container clearfix">

    <a class="header-logo-wordmark" href="https://github.com/">Github</a>

    <div class="header-actions">
      <a class="button primary" href="/signup">Sign up</a>
      <a class="button" href="/login?return_to=%2Ftrentrichardson%2FjQuery-Timepicker-Addon%2Fblob%2Fmaster%2Fjquery-ui-sliderAccess.js">Sign in</a>
    </div>

    <div class="command-bar js-command-bar  in-repository">


      <ul class="top-nav">
          <li class="explore"><a href="/explore">Explore</a></li>
        <li class="features"><a href="/features">Features</a></li>
          <li class="enterprise"><a href="http://enterprise.github.com/">Enterprise</a></li>
          <li class="blog"><a href="/blog">Blog</a></li>
      </ul>
        <form accept-charset="UTF-8" action="/search" class="command-bar-form" id="top_search_form" method="get">
  <a href="/search/advanced" class="advanced-search-icon tooltipped downwards command-bar-search" id="advanced_search" title="Advanced search"><span class="octicon octicon-gear "></span></a>

  <input type="text" data-hotkey="/ s" name="q" id="js-command-bar-field" placeholder="Search or type a command" tabindex="1" autocapitalize="off"
    
      data-repo="trentrichardson/jQuery-Timepicker-Addon"
      data-branch="master"
      data-sha="d13f75ef213ae7f9275f80a7e028fbb1cc5492b7"
  >

    <input type="hidden" name="nwo" value="trentrichardson/jQuery-Timepicker-Addon" />

    <div class="select-menu js-menu-container js-select-menu search-context-select-menu">
      <span class="minibutton select-menu-button js-menu-target">
        <span class="js-select-button">This repository</span>
      </span>

      <div class="select-menu-modal-holder js-menu-content js-navigation-container">
        <div class="select-menu-modal">

          <div class="select-menu-item js-navigation-item selected">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" class="js-search-this-repository" name="search_target" value="repository" checked="checked" />
            <div class="select-menu-item-text js-select-button-text">This repository</div>
          </div> <!-- /.select-menu-item -->

          <div class="select-menu-item js-navigation-item">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" name="search_target" value="global" />
            <div class="select-menu-item-text js-select-button-text">All repositories</div>
          </div> <!-- /.select-menu-item -->

        </div>
      </div>
    </div>

  <span class="octicon help tooltipped downwards" title="Show command bar help">
    <span class="octicon octicon-question"></span>
  </span>


  <input type="hidden" name="ref" value="cmdform">

  <div class="divider-vertical"></div>

</form>
    </div>

  </div>
</div>


      


            <div class="site hfeed" itemscope itemtype="http://schema.org/WebPage">
      <div class="hentry">
        
        <div class="pagehead repohead instapaper_ignore readability-menu ">
          <div class="container">
            <div class="title-actions-bar">
              

<ul class="pagehead-actions">



    <li>
      <a href="/login?return_to=%2Ftrentrichardson%2FjQuery-Timepicker-Addon"
        class="minibutton js-toggler-target star-button entice tooltipped upwards"
        title="You must be signed in to use this feature" rel="nofollow">
        <span class="octicon octicon-star"></span>Star
      </a>
      <a class="social-count js-social-count" href="/trentrichardson/jQuery-Timepicker-Addon/stargazers">
        1,538
      </a>
    </li>
    <li>
      <a href="/login?return_to=%2Ftrentrichardson%2FjQuery-Timepicker-Addon"
        class="minibutton js-toggler-target fork-button entice tooltipped upwards"
        title="You must be signed in to fork a repository" rel="nofollow">
        <span class="octicon octicon-git-branch"></span>Fork
      </a>
      <a href="/trentrichardson/jQuery-Timepicker-Addon/network" class="social-count">
        480
      </a>
    </li>
</ul>

              <h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="entry-title public">
                <span class="repo-label"><span>public</span></span>
                <span class="mega-octicon octicon-repo"></span>
                <span class="author vcard">
                  <a href="/trentrichardson" class="url fn" itemprop="url" rel="author">
                  <span itemprop="title">trentrichardson</span>
                  </a></span> /
                <strong><a href="/trentrichardson/jQuery-Timepicker-Addon" class="js-current-repository">jQuery-Timepicker-Addon</a></strong>
              </h1>
            </div>

            
  <ul class="tabs">
    <li class="pulse-nav"><a href="/trentrichardson/jQuery-Timepicker-Addon/pulse" class="js-selected-navigation-item " data-selected-links="pulse /trentrichardson/jQuery-Timepicker-Addon/pulse" rel="nofollow"><span class="octicon octicon-pulse"></span></a></li>
    <li><a href="/trentrichardson/jQuery-Timepicker-Addon" class="js-selected-navigation-item selected" data-selected-links="repo_source repo_downloads repo_commits repo_tags repo_branches /trentrichardson/jQuery-Timepicker-Addon">Code</a></li>
    <li><a href="/trentrichardson/jQuery-Timepicker-Addon/network" class="js-selected-navigation-item " data-selected-links="repo_network /trentrichardson/jQuery-Timepicker-Addon/network">Network</a></li>
    <li><a href="/trentrichardson/jQuery-Timepicker-Addon/pulls" class="js-selected-navigation-item " data-selected-links="repo_pulls /trentrichardson/jQuery-Timepicker-Addon/pulls">Pull Requests <span class='counter'>0</span></a></li>

      <li><a href="/trentrichardson/jQuery-Timepicker-Addon/issues" class="js-selected-navigation-item " data-selected-links="repo_issues /trentrichardson/jQuery-Timepicker-Addon/issues">Issues <span class='counter'>236</span></a></li>



    <li><a href="/trentrichardson/jQuery-Timepicker-Addon/graphs" class="js-selected-navigation-item " data-selected-links="repo_graphs repo_contributors /trentrichardson/jQuery-Timepicker-Addon/graphs">Graphs</a></li>


  </ul>
  
<div class="tabnav">

  <span class="tabnav-right">
    <ul class="tabnav-tabs">
          <li><a href="/trentrichardson/jQuery-Timepicker-Addon/tags" class="js-selected-navigation-item tabnav-tab" data-selected-links="repo_tags /trentrichardson/jQuery-Timepicker-Addon/tags">Tags <span class="counter ">24</span></a></li>
    </ul>
  </span>

  <div class="tabnav-widget scope">


    <div class="select-menu js-menu-container js-select-menu js-branch-menu">
      <a class="minibutton select-menu-button js-menu-target" data-hotkey="w" data-ref="master">
        <span class="octicon octicon-branch"></span>
        <i>branch:</i>
        <span class="js-select-button">master</span>
      </a>

      <div class="select-menu-modal-holder js-menu-content js-navigation-container">

        <div class="select-menu-modal">
          <div class="select-menu-header">
            <span class="select-menu-title">Switch branches/tags</span>
            <span class="octicon octicon-remove-close js-menu-close"></span>
          </div> <!-- /.select-menu-header -->

          <div class="select-menu-filters">
            <div class="select-menu-text-filter">
              <input type="text" id="commitish-filter-field" class="js-filterable-field js-navigation-enable" placeholder="Filter branches/tags">
            </div>
            <div class="select-menu-tabs">
              <ul>
                <li class="select-menu-tab">
                  <a href="#" data-tab-filter="branches" class="js-select-menu-tab">Branches</a>
                </li>
                <li class="select-menu-tab">
                  <a href="#" data-tab-filter="tags" class="js-select-menu-tab">Tags</a>
                </li>
              </ul>
            </div><!-- /.select-menu-tabs -->
          </div><!-- /.select-menu-filters -->

          <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket css-truncate" data-tab-filter="branches">

            <div data-filterable-for="commitish-filter-field" data-filterable-type="substring">

                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/dev/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="dev" rel="nofollow" title="dev">dev</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item selected">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/master/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="master" rel="nofollow" title="master">master</a>
                </div> <!-- /.select-menu-item -->
            </div>

              <div class="select-menu-no-results">Nothing to show</div>
          </div> <!-- /.select-menu-list -->


          <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket css-truncate" data-tab-filter="tags">
            <div data-filterable-for="commitish-filter-field" data-filterable-type="substring">

                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.3/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.3" rel="nofollow" title="v1.3">v1.3</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.2.2/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.2.2" rel="nofollow" title="v1.2.2">v1.2.2</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.2.1/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.2.1" rel="nofollow" title="v1.2.1">v1.2.1</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.2/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.2" rel="nofollow" title="v1.2">v1.2</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.1.2/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.1.2" rel="nofollow" title="v1.1.2">v1.1.2</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.1.1/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.1.1" rel="nofollow" title="v1.1.1">v1.1.1</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.1.0/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.1.0" rel="nofollow" title="v1.1.0">v1.1.0</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.0.5/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.0.5" rel="nofollow" title="v1.0.5">v1.0.5</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.0.4/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.0.4" rel="nofollow" title="v1.0.4">v1.0.4</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.0.3/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.0.3" rel="nofollow" title="v1.0.3">v1.0.3</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.0.2/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.0.2" rel="nofollow" title="v1.0.2">v1.0.2</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.0.1/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.0.1" rel="nofollow" title="v1.0.1">v1.0.1</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v1.0.0/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v1.0.0" rel="nofollow" title="v1.0.0">v1.0.0</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.9/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.9" rel="nofollow" title="v0.9.9">v0.9.9</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.8/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.8" rel="nofollow" title="v0.9.8">v0.9.8</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.7/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.7" rel="nofollow" title="v0.9.7">v0.9.7</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.6/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.6" rel="nofollow" title="v0.9.6">v0.9.6</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.5/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.5" rel="nofollow" title="v0.9.5">v0.9.5</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.4/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.4" rel="nofollow" title="v0.9.4">v0.9.4</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.3/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.3" rel="nofollow" title="v0.9.3">v0.9.3</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.2/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.2" rel="nofollow" title="v0.9.2">v0.9.2</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9.1/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9.1" rel="nofollow" title="v0.9.1">v0.9.1</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.9/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.9" rel="nofollow" title="v0.9">v0.9</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/blob/v0.8/jquery-ui-sliderAccess.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="v0.8" rel="nofollow" title="v0.8">v0.8</a>
                </div> <!-- /.select-menu-item -->
            </div>

            <div class="select-menu-no-results">Nothing to show</div>

          </div> <!-- /.select-menu-list -->

        </div> <!-- /.select-menu-modal -->
      </div> <!-- /.select-menu-modal-holder -->
    </div> <!-- /.select-menu -->

  </div> <!-- /.scope -->

  <ul class="tabnav-tabs">
    <li><a href="/trentrichardson/jQuery-Timepicker-Addon" class="selected js-selected-navigation-item tabnav-tab" data-selected-links="repo_source /trentrichardson/jQuery-Timepicker-Addon">Files</a></li>
    <li><a href="/trentrichardson/jQuery-Timepicker-Addon/commits/master" class="js-selected-navigation-item tabnav-tab" data-selected-links="repo_commits /trentrichardson/jQuery-Timepicker-Addon/commits/master">Commits</a></li>
    <li><a href="/trentrichardson/jQuery-Timepicker-Addon/branches" class="js-selected-navigation-item tabnav-tab" data-selected-links="repo_branches /trentrichardson/jQuery-Timepicker-Addon/branches" rel="nofollow">Branches <span class="counter ">2</span></a></li>
  </ul>

</div>

  
  
  


            
          </div>
        </div><!-- /.repohead -->

        <div id="js-repo-pjax-container" class="container context-loader-container" data-pjax-container>
          


<!-- blob contrib key: blob_contributors:v21:29134aa1fe2dc448575ccab9895d765c -->
<!-- blob contrib frag key: views10/v8/blob_contributors:v21:29134aa1fe2dc448575ccab9895d765c -->


<div id="slider">
    <div class="frame-meta">

      <p title="This is a placeholder element" class="js-history-link-replace hidden"></p>

        <div class="breadcrumb">
          <span class='bold'><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/trentrichardson/jQuery-Timepicker-Addon" class="js-slide-to" data-branch="master" data-direction="back" itemscope="url"><span itemprop="title">jQuery-Timepicker-Addon</span></a></span></span><span class="separator"> / </span><strong class="final-path">jquery-ui-sliderAccess.js</strong> <span class="js-zeroclipboard zeroclipboard-button" data-clipboard-text="jquery-ui-sliderAccess.js" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
        </div>

      <a href="/trentrichardson/jQuery-Timepicker-Addon/find/master" class="js-slide-to" data-hotkey="t" style="display:none">Show File Finder</a>


        
  <div class="commit file-history-tease">
    <img class="main-avatar" height="24" src="https://secure.gravatar.com/avatar/ab4c8036b1eb49d51feac4ab23975c91?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
    <span class="author"><a href="/trentrichardson" rel="author">trentrichardson</a></span>
    <time class="js-relative-date" datetime="2012-10-22T13:16:06-07:00" title="2012-10-22 13:16:06">October 22, 2012</time>
    <div class="commit-title">
        <a href="/trentrichardson/jQuery-Timepicker-Addon/commit/8a2a323cba9657e99c17f22cfca35858a75d7b1b" class="message">Default events if not exist</a>
    </div>

    <div class="participation">
      <p class="quickstat"><a href="#blob_contributors_box" rel="facebox"><strong>1</strong> contributor</a></p>
      
    </div>
    <div id="blob_contributors_box" style="display:none">
      <h2>Users on GitHub who have contributed to this file</h2>
      <ul class="facebox-user-list">
        <li>
          <img height="24" src="https://secure.gravatar.com/avatar/ab4c8036b1eb49d51feac4ab23975c91?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/trentrichardson">trentrichardson</a>
        </li>
      </ul>
    </div>
  </div>


    </div><!-- ./.frame-meta -->

    <div class="frames">
      <div class="frame" data-permalink-url="/trentrichardson/jQuery-Timepicker-Addon/blob/ce3acd87971f04be08c0a7c2cbb18a25acf891c0/jquery-ui-sliderAccess.js" data-title="jQuery-Timepicker-Addon/jquery-ui-sliderAccess.js at master · trentrichardson/jQuery-Timepicker-Addon · GitHub" data-type="blob">

        <div id="files" class="bubble">
          <div class="file">
            <div class="meta">
              <div class="info">
                <span class="icon"><b class="octicon octicon-file-text"></b></span>
                <span class="mode" title="File Mode">file</span>
                  <span>89 lines (77 sloc)</span>
                <span>3.052 kb</span>
              </div>
              <div class="actions">
                <div class="button-group">
                      <a class="minibutton js-entice" href=""
                         data-entice="You must be signed in and on a branch to make or propose changes">Edit</a>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/raw/master/jquery-ui-sliderAccess.js" class="button minibutton " id="raw-url">Raw</a>
                    <a href="/trentrichardson/jQuery-Timepicker-Addon/blame/master/jquery-ui-sliderAccess.js" class="button minibutton ">Blame</a>
                  <a href="/trentrichardson/jQuery-Timepicker-Addon/commits/master/jquery-ui-sliderAccess.js" class="button minibutton " rel="nofollow">History</a>
                </div><!-- /.button-group -->
              </div><!-- /.actions -->

            </div>
                <div class="blob-wrapper data type-javascript js-blob-data">
      <table class="file-code file-diff">
        <tr class="file-code-line">
          <td class="blob-line-nums">
            <span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
<span id="L29" rel="#L29">29</span>
<span id="L30" rel="#L30">30</span>
<span id="L31" rel="#L31">31</span>
<span id="L32" rel="#L32">32</span>
<span id="L33" rel="#L33">33</span>
<span id="L34" rel="#L34">34</span>
<span id="L35" rel="#L35">35</span>
<span id="L36" rel="#L36">36</span>
<span id="L37" rel="#L37">37</span>
<span id="L38" rel="#L38">38</span>
<span id="L39" rel="#L39">39</span>
<span id="L40" rel="#L40">40</span>
<span id="L41" rel="#L41">41</span>
<span id="L42" rel="#L42">42</span>
<span id="L43" rel="#L43">43</span>
<span id="L44" rel="#L44">44</span>
<span id="L45" rel="#L45">45</span>
<span id="L46" rel="#L46">46</span>
<span id="L47" rel="#L47">47</span>
<span id="L48" rel="#L48">48</span>
<span id="L49" rel="#L49">49</span>
<span id="L50" rel="#L50">50</span>
<span id="L51" rel="#L51">51</span>
<span id="L52" rel="#L52">52</span>
<span id="L53" rel="#L53">53</span>
<span id="L54" rel="#L54">54</span>
<span id="L55" rel="#L55">55</span>
<span id="L56" rel="#L56">56</span>
<span id="L57" rel="#L57">57</span>
<span id="L58" rel="#L58">58</span>
<span id="L59" rel="#L59">59</span>
<span id="L60" rel="#L60">60</span>
<span id="L61" rel="#L61">61</span>
<span id="L62" rel="#L62">62</span>
<span id="L63" rel="#L63">63</span>
<span id="L64" rel="#L64">64</span>
<span id="L65" rel="#L65">65</span>
<span id="L66" rel="#L66">66</span>
<span id="L67" rel="#L67">67</span>
<span id="L68" rel="#L68">68</span>
<span id="L69" rel="#L69">69</span>
<span id="L70" rel="#L70">70</span>
<span id="L71" rel="#L71">71</span>
<span id="L72" rel="#L72">72</span>
<span id="L73" rel="#L73">73</span>
<span id="L74" rel="#L74">74</span>
<span id="L75" rel="#L75">75</span>
<span id="L76" rel="#L76">76</span>
<span id="L77" rel="#L77">77</span>
<span id="L78" rel="#L78">78</span>
<span id="L79" rel="#L79">79</span>
<span id="L80" rel="#L80">80</span>
<span id="L81" rel="#L81">81</span>
<span id="L82" rel="#L82">82</span>
<span id="L83" rel="#L83">83</span>
<span id="L84" rel="#L84">84</span>
<span id="L85" rel="#L85">85</span>
<span id="L86" rel="#L86">86</span>
<span id="L87" rel="#L87">87</span>
<span id="L88" rel="#L88">88</span>
<span id="L89" rel="#L89">89</span>

          </td>
          <td class="blob-line-code">
                  <div class="highlight"><pre><div class='line' id='LC1'><span class="cm">/*</span></div><div class='line' id='LC2'><span class="cm"> * jQuery UI Slider Access</span></div><div class='line' id='LC3'><span class="cm"> * By: Trent Richardson [http://trentrichardson.com]</span></div><div class='line' id='LC4'><span class="cm"> * Version 0.3</span></div><div class='line' id='LC5'><span class="cm"> * Last Modified: 10/20/2012</span></div><div class='line' id='LC6'><span class="cm"> * </span></div><div class='line' id='LC7'><span class="cm"> * Copyright 2011 Trent Richardson</span></div><div class='line' id='LC8'><span class="cm"> * Dual licensed under the MIT and GPL licenses.</span></div><div class='line' id='LC9'><span class="cm"> * http://trentrichardson.com/Impromptu/GPL-LICENSE.txt</span></div><div class='line' id='LC10'><span class="cm"> * http://trentrichardson.com/Impromptu/MIT-LICENSE.txt</span></div><div class='line' id='LC11'><span class="cm"> * </span></div><div class='line' id='LC12'><span class="cm"> */</span></div><div class='line' id='LC13'> <span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">$</span><span class="p">){</span></div><div class='line' id='LC14'><br/></div><div class='line' id='LC15'>	<span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">extend</span><span class="p">({</span></div><div class='line' id='LC16'>		<span class="nx">sliderAccess</span><span class="o">:</span> <span class="kd">function</span><span class="p">(</span><span class="nx">options</span><span class="p">){</span></div><div class='line' id='LC17'>			<span class="nx">options</span> <span class="o">=</span> <span class="nx">options</span> <span class="o">||</span> <span class="p">{};</span></div><div class='line' id='LC18'>			<span class="nx">options</span><span class="p">.</span><span class="nx">touchonly</span> <span class="o">=</span> <span class="nx">options</span><span class="p">.</span><span class="nx">touchonly</span> <span class="o">!==</span> <span class="kc">undefined</span><span class="o">?</span> <span class="nx">options</span><span class="p">.</span><span class="nx">touchonly</span> <span class="o">:</span> <span class="kc">true</span><span class="p">;</span> <span class="c1">// by default only show it if touch device</span></div><div class='line' id='LC19'><br/></div><div class='line' id='LC20'>			<span class="k">if</span><span class="p">(</span><span class="nx">options</span><span class="p">.</span><span class="nx">touchonly</span> <span class="o">===</span> <span class="kc">true</span> <span class="o">&amp;&amp;</span> <span class="o">!</span><span class="p">(</span><span class="s2">&quot;ontouchend&quot;</span> <span class="k">in</span> <span class="nb">document</span><span class="p">))</span></div><div class='line' id='LC21'>				<span class="k">return</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">);</span></div><div class='line' id='LC22'><br/></div><div class='line' id='LC23'>			<span class="k">return</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">).</span><span class="nx">each</span><span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">i</span><span class="p">,</span><span class="nx">obj</span><span class="p">){</span></div><div class='line' id='LC24'>						<span class="kd">var</span> <span class="nx">$t</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">),</span></div><div class='line' id='LC25'>							<span class="nx">o</span> <span class="o">=</span> <span class="nx">$</span><span class="p">.</span><span class="nx">extend</span><span class="p">({},{</span> </div><div class='line' id='LC26'>											<span class="nx">where</span><span class="o">:</span> <span class="s1">&#39;after&#39;</span><span class="p">,</span></div><div class='line' id='LC27'>											<span class="nx">step</span><span class="o">:</span> <span class="nx">$t</span><span class="p">.</span><span class="nx">slider</span><span class="p">(</span><span class="s1">&#39;option&#39;</span><span class="p">,</span><span class="s1">&#39;step&#39;</span><span class="p">),</span> </div><div class='line' id='LC28'>											<span class="nx">upIcon</span><span class="o">:</span> <span class="s1">&#39;ui-icon-plus&#39;</span><span class="p">,</span> </div><div class='line' id='LC29'>											<span class="nx">downIcon</span><span class="o">:</span> <span class="s1">&#39;ui-icon-minus&#39;</span><span class="p">,</span></div><div class='line' id='LC30'>											<span class="nx">text</span><span class="o">:</span> <span class="kc">false</span><span class="p">,</span></div><div class='line' id='LC31'>											<span class="nx">upText</span><span class="o">:</span> <span class="s1">&#39;+&#39;</span><span class="p">,</span></div><div class='line' id='LC32'>											<span class="nx">downText</span><span class="o">:</span> <span class="s1">&#39;-&#39;</span><span class="p">,</span></div><div class='line' id='LC33'>											<span class="nx">buttonset</span><span class="o">:</span> <span class="kc">true</span><span class="p">,</span></div><div class='line' id='LC34'>											<span class="nx">buttonsetTag</span><span class="o">:</span> <span class="s1">&#39;span&#39;</span><span class="p">,</span></div><div class='line' id='LC35'>											<span class="nx">isRTL</span><span class="o">:</span> <span class="kc">false</span></div><div class='line' id='LC36'>										<span class="p">},</span> <span class="nx">options</span><span class="p">),</span></div><div class='line' id='LC37'>							<span class="nx">$buttons</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="s1">&#39;&lt;&#39;</span><span class="o">+</span> <span class="nx">o</span><span class="p">.</span><span class="nx">buttonsetTag</span> <span class="o">+</span><span class="s1">&#39; class=&quot;ui-slider-access&quot;&gt;&#39;</span><span class="o">+</span></div><div class='line' id='LC38'>											<span class="s1">&#39;&lt;button data-icon=&quot;&#39;</span><span class="o">+</span> <span class="nx">o</span><span class="p">.</span><span class="nx">downIcon</span> <span class="o">+</span><span class="s1">&#39;&quot; data-step=&quot;&#39;</span><span class="o">+</span> <span class="p">(</span><span class="nx">o</span><span class="p">.</span><span class="nx">isRTL</span><span class="o">?</span> <span class="nx">o</span><span class="p">.</span><span class="nx">step</span> <span class="o">:</span> <span class="nx">o</span><span class="p">.</span><span class="nx">step</span><span class="o">*-</span><span class="mi">1</span><span class="p">)</span> <span class="o">+</span><span class="s1">&#39;&quot;&gt;&#39;</span><span class="o">+</span> <span class="nx">o</span><span class="p">.</span><span class="nx">downText</span> <span class="o">+</span><span class="s1">&#39;&lt;/button&gt;&#39;</span><span class="o">+</span></div><div class='line' id='LC39'>											<span class="s1">&#39;&lt;button data-icon=&quot;&#39;</span><span class="o">+</span> <span class="nx">o</span><span class="p">.</span><span class="nx">upIcon</span> <span class="o">+</span><span class="s1">&#39;&quot; data-step=&quot;&#39;</span><span class="o">+</span> <span class="p">(</span><span class="nx">o</span><span class="p">.</span><span class="nx">isRTL</span><span class="o">?</span> <span class="nx">o</span><span class="p">.</span><span class="nx">step</span><span class="o">*-</span><span class="mi">1</span> <span class="o">:</span> <span class="nx">o</span><span class="p">.</span><span class="nx">step</span><span class="p">)</span> <span class="o">+</span><span class="s1">&#39;&quot;&gt;&#39;</span><span class="o">+</span> <span class="nx">o</span><span class="p">.</span><span class="nx">upText</span> <span class="o">+</span><span class="s1">&#39;&lt;/button&gt;&#39;</span><span class="o">+</span></div><div class='line' id='LC40'>										<span class="s1">&#39;&lt;/&#39;</span><span class="o">+</span> <span class="nx">o</span><span class="p">.</span><span class="nx">buttonsetTag</span> <span class="o">+</span><span class="s1">&#39;&gt;&#39;</span><span class="p">);</span></div><div class='line' id='LC41'><br/></div><div class='line' id='LC42'>						<span class="nx">$buttons</span><span class="p">.</span><span class="nx">children</span><span class="p">(</span><span class="s1">&#39;button&#39;</span><span class="p">).</span><span class="nx">each</span><span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">j</span><span class="p">,</span> <span class="nx">jobj</span><span class="p">){</span></div><div class='line' id='LC43'>							<span class="kd">var</span> <span class="nx">$jt</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">);</span></div><div class='line' id='LC44'>							<span class="nx">$jt</span><span class="p">.</span><span class="nx">button</span><span class="p">({</span> </div><div class='line' id='LC45'>											<span class="nx">text</span><span class="o">:</span> <span class="nx">o</span><span class="p">.</span><span class="nx">text</span><span class="p">,</span> </div><div class='line' id='LC46'>											<span class="nx">icons</span><span class="o">:</span> <span class="p">{</span> <span class="nx">primary</span><span class="o">:</span> <span class="nx">$jt</span><span class="p">.</span><span class="nx">data</span><span class="p">(</span><span class="s1">&#39;icon&#39;</span><span class="p">)</span> <span class="p">}</span></div><div class='line' id='LC47'>										<span class="p">})</span></div><div class='line' id='LC48'>								<span class="p">.</span><span class="nx">click</span><span class="p">(</span><span class="kd">function</span><span class="p">(</span><span class="nx">e</span><span class="p">){</span></div><div class='line' id='LC49'>											<span class="kd">var</span> <span class="nx">step</span> <span class="o">=</span> <span class="nx">$jt</span><span class="p">.</span><span class="nx">data</span><span class="p">(</span><span class="s1">&#39;step&#39;</span><span class="p">),</span></div><div class='line' id='LC50'>												<span class="nx">curr</span> <span class="o">=</span> <span class="nx">$t</span><span class="p">.</span><span class="nx">slider</span><span class="p">(</span><span class="s1">&#39;value&#39;</span><span class="p">),</span></div><div class='line' id='LC51'>												<span class="nx">newval</span> <span class="o">=</span> <span class="nx">curr</span> <span class="o">+=</span> <span class="nx">step</span><span class="o">*</span><span class="mi">1</span><span class="p">,</span></div><div class='line' id='LC52'>												<span class="nx">minval</span> <span class="o">=</span> <span class="nx">$t</span><span class="p">.</span><span class="nx">slider</span><span class="p">(</span><span class="s1">&#39;option&#39;</span><span class="p">,</span><span class="s1">&#39;min&#39;</span><span class="p">),</span></div><div class='line' id='LC53'>												<span class="nx">maxval</span> <span class="o">=</span> <span class="nx">$t</span><span class="p">.</span><span class="nx">slider</span><span class="p">(</span><span class="s1">&#39;option&#39;</span><span class="p">,</span><span class="s1">&#39;max&#39;</span><span class="p">),</span></div><div class='line' id='LC54'>												<span class="nx">slidee</span> <span class="o">=</span> <span class="nx">$t</span><span class="p">.</span><span class="nx">slider</span><span class="p">(</span><span class="s2">&quot;option&quot;</span><span class="p">,</span> <span class="s2">&quot;slide&quot;</span><span class="p">)</span> <span class="o">||</span> <span class="kd">function</span><span class="p">(){},</span></div><div class='line' id='LC55'>												<span class="nx">stope</span> <span class="o">=</span> <span class="nx">$t</span><span class="p">.</span><span class="nx">slider</span><span class="p">(</span><span class="s2">&quot;option&quot;</span><span class="p">,</span> <span class="s2">&quot;stop&quot;</span><span class="p">)</span> <span class="o">||</span> <span class="kd">function</span><span class="p">(){};</span></div><div class='line' id='LC56'><br/></div><div class='line' id='LC57'>											<span class="nx">e</span><span class="p">.</span><span class="nx">preventDefault</span><span class="p">();</span></div><div class='line' id='LC58'><br/></div><div class='line' id='LC59'>											<span class="k">if</span><span class="p">(</span><span class="nx">newval</span> <span class="o">&lt;</span> <span class="nx">minval</span> <span class="o">||</span> <span class="nx">newval</span> <span class="o">&gt;</span> <span class="nx">maxval</span><span class="p">)</span></div><div class='line' id='LC60'>												<span class="k">return</span><span class="p">;</span></div><div class='line' id='LC61'><br/></div><div class='line' id='LC62'>											<span class="nx">$t</span><span class="p">.</span><span class="nx">slider</span><span class="p">(</span><span class="s1">&#39;value&#39;</span><span class="p">,</span> <span class="nx">newval</span><span class="p">);</span></div><div class='line' id='LC63'><br/></div><div class='line' id='LC64'>											<span class="nx">slidee</span><span class="p">.</span><span class="nx">call</span><span class="p">(</span><span class="nx">$t</span><span class="p">,</span> <span class="kc">null</span><span class="p">,</span> <span class="p">{</span> <span class="nx">value</span><span class="o">:</span> <span class="nx">newval</span> <span class="p">});</span></div><div class='line' id='LC65'>											<span class="nx">stope</span><span class="p">.</span><span class="nx">call</span><span class="p">(</span><span class="nx">$t</span><span class="p">,</span> <span class="kc">null</span><span class="p">,</span> <span class="p">{</span> <span class="nx">value</span><span class="o">:</span> <span class="nx">newval</span> <span class="p">});</span></div><div class='line' id='LC66'>										<span class="p">});</span></div><div class='line' id='LC67'>						<span class="p">});</span></div><div class='line' id='LC68'><br/></div><div class='line' id='LC69'>						<span class="c1">// before or after					</span></div><div class='line' id='LC70'>						<span class="nx">$t</span><span class="p">[</span><span class="nx">o</span><span class="p">.</span><span class="nx">where</span><span class="p">](</span><span class="nx">$buttons</span><span class="p">);</span></div><div class='line' id='LC71'><br/></div><div class='line' id='LC72'>						<span class="k">if</span><span class="p">(</span><span class="nx">o</span><span class="p">.</span><span class="nx">buttonset</span><span class="p">){</span></div><div class='line' id='LC73'>							<span class="nx">$buttons</span><span class="p">.</span><span class="nx">removeClass</span><span class="p">(</span><span class="s1">&#39;ui-corner-right&#39;</span><span class="p">).</span><span class="nx">removeClass</span><span class="p">(</span><span class="s1">&#39;ui-corner-left&#39;</span><span class="p">).</span><span class="nx">buttonset</span><span class="p">();</span></div><div class='line' id='LC74'>							<span class="nx">$buttons</span><span class="p">.</span><span class="nx">eq</span><span class="p">(</span><span class="mi">0</span><span class="p">).</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;ui-corner-left&#39;</span><span class="p">);</span></div><div class='line' id='LC75'>							<span class="nx">$buttons</span><span class="p">.</span><span class="nx">eq</span><span class="p">(</span><span class="mi">1</span><span class="p">).</span><span class="nx">addClass</span><span class="p">(</span><span class="s1">&#39;ui-corner-right&#39;</span><span class="p">);</span></div><div class='line' id='LC76'>						<span class="p">}</span></div><div class='line' id='LC77'><br/></div><div class='line' id='LC78'>						<span class="c1">// adjust the width so we don&#39;t break the original layout</span></div><div class='line' id='LC79'>						<span class="kd">var</span> <span class="nx">bOuterWidth</span> <span class="o">=</span> <span class="nx">$buttons</span><span class="p">.</span><span class="nx">css</span><span class="p">({</span></div><div class='line' id='LC80'>									<span class="nx">marginLeft</span><span class="o">:</span> <span class="p">((</span><span class="nx">o</span><span class="p">.</span><span class="nx">where</span> <span class="o">==</span> <span class="s1">&#39;after&#39;</span> <span class="o">&amp;&amp;</span> <span class="o">!</span><span class="nx">o</span><span class="p">.</span><span class="nx">isRTL</span><span class="p">)</span> <span class="o">||</span> <span class="p">(</span><span class="nx">o</span><span class="p">.</span><span class="nx">where</span> <span class="o">==</span> <span class="s1">&#39;before&#39;</span> <span class="o">&amp;&amp;</span> <span class="nx">o</span><span class="p">.</span><span class="nx">isRTL</span><span class="p">)</span><span class="o">?</span> <span class="mi">10</span><span class="o">:</span><span class="mi">0</span><span class="p">),</span> </div><div class='line' id='LC81'>									<span class="nx">marginRight</span><span class="o">:</span> <span class="p">((</span><span class="nx">o</span><span class="p">.</span><span class="nx">where</span> <span class="o">==</span> <span class="s1">&#39;before&#39;</span> <span class="o">&amp;&amp;</span> <span class="o">!</span><span class="nx">o</span><span class="p">.</span><span class="nx">isRTL</span><span class="p">)</span> <span class="o">||</span> <span class="p">(</span><span class="nx">o</span><span class="p">.</span><span class="nx">where</span> <span class="o">==</span> <span class="s1">&#39;after&#39;</span> <span class="o">&amp;&amp;</span> <span class="nx">o</span><span class="p">.</span><span class="nx">isRTL</span><span class="p">)</span><span class="o">?</span> <span class="mi">10</span><span class="o">:</span><span class="mi">0</span><span class="p">)</span></div><div class='line' id='LC82'>								<span class="p">}).</span><span class="nx">outerWidth</span><span class="p">(</span><span class="kc">true</span><span class="p">)</span> <span class="o">+</span> <span class="mi">5</span><span class="p">;</span></div><div class='line' id='LC83'>						<span class="kd">var</span> <span class="nx">tOuterWidth</span> <span class="o">=</span> <span class="nx">$t</span><span class="p">.</span><span class="nx">outerWidth</span><span class="p">(</span><span class="kc">true</span><span class="p">);</span></div><div class='line' id='LC84'>						<span class="nx">$t</span><span class="p">.</span><span class="nx">css</span><span class="p">(</span><span class="s1">&#39;display&#39;</span><span class="p">,</span><span class="s1">&#39;inline-block&#39;</span><span class="p">).</span><span class="nx">width</span><span class="p">(</span><span class="nx">tOuterWidth</span><span class="o">-</span><span class="nx">bOuterWidth</span><span class="p">);</span></div><div class='line' id='LC85'>					<span class="p">});</span>		</div><div class='line' id='LC86'>		<span class="p">}</span></div><div class='line' id='LC87'>	<span class="p">});</span></div><div class='line' id='LC88'><br/></div><div class='line' id='LC89'><span class="p">})(</span><span class="nx">jQuery</span><span class="p">);</span></div></pre></div>
          </td>
        </tr>
      </table>
  </div>

          </div>
        </div>

        <a href="#jump-to-line" rel="facebox" data-hotkey="l" class="js-jump-to-line" style="display:none">Jump to Line</a>
        <div id="jump-to-line" style="display:none">
          <h2>Jump to Line</h2>
          <form accept-charset="UTF-8" class="js-jump-to-line-form">
            <input class="textfield js-jump-to-line-field" type="text">
            <div class="full-button">
              <button type="submit" class="button">Go</button>
            </div>
          </form>
        </div>

      </div>
    </div>
</div>

<div id="js-frame-loading-template" class="frame frame-loading large-loading-area" style="display:none;">
  <img class="js-frame-loading-spinner" src="https://a248.e.akamai.net/assets.github.com/images/spinners/octocat-spinner-128.gif?1347543527" height="64" width="64">
</div>


        </div>
      </div>
      <div class="modal-backdrop"></div>
    </div>

      <div id="footer-push"></div><!-- hack for sticky footer -->
    </div><!-- end of wrapper - hack for sticky footer -->

      <!-- footer -->
      <div id="footer">
  <div class="container clearfix">

      <dl class="footer_nav">
        <dt>GitHub</dt>
        <dd><a href="/about">About us</a></dd>
        <dd><a href="/blog">Blog</a></dd>
        <dd><a href="/contact">Contact &amp; support</a></dd>
        <dd><a href="http://enterprise.github.com/">GitHub Enterprise</a></dd>
        <dd><a href="http://status.github.com/">Site status</a></dd>
      </dl>

      <dl class="footer_nav">
        <dt>Applications</dt>
        <dd><a href="http://mac.github.com/">GitHub for Mac</a></dd>
        <dd><a href="http://windows.github.com/">GitHub for Windows</a></dd>
        <dd><a href="http://eclipse.github.com/">GitHub for Eclipse</a></dd>
        <dd><a href="http://mobile.github.com/">GitHub mobile apps</a></dd>
      </dl>

      <dl class="footer_nav">
        <dt>Services</dt>
        <dd><a href="http://get.gaug.es/">Gauges: Web analytics</a></dd>
        <dd><a href="http://speakerdeck.com">Speaker Deck: Presentations</a></dd>
        <dd><a href="https://gist.github.com">Gist: Code snippets</a></dd>
        <dd><a href="http://jobs.github.com/">Job board</a></dd>
      </dl>

      <dl class="footer_nav">
        <dt>Documentation</dt>
        <dd><a href="http://help.github.com/">GitHub Help</a></dd>
        <dd><a href="http://developer.github.com/">Developer API</a></dd>
        <dd><a href="http://github.github.com/github-flavored-markdown/">GitHub Flavored Markdown</a></dd>
        <dd><a href="http://pages.github.com/">GitHub Pages</a></dd>
      </dl>

      <dl class="footer_nav">
        <dt>More</dt>
        <dd><a href="http://training.github.com/">Training</a></dd>
        <dd><a href="/edu">Students &amp; teachers</a></dd>
        <dd><a href="http://shop.github.com">The Shop</a></dd>
        <dd><a href="/plans">Plans &amp; pricing</a></dd>
        <dd><a href="http://octodex.github.com/">The Octodex</a></dd>
      </dl>

      <hr class="footer-divider">


    <p class="right">&copy; 2013 <span title="0.07080s from fe18.rs.github.com">GitHub</span>, Inc. All rights reserved.</p>
    <a class="left" href="/">
      <span class="mega-octicon octicon-mark-github"></span>
    </a>
    <ul id="legal">
        <li><a href="/site/terms">Terms of Service</a></li>
        <li><a href="/site/privacy">Privacy</a></li>
        <li><a href="/security">Security</a></li>
    </ul>

  </div><!-- /.container -->

</div><!-- /.#footer -->


    <div class="fullscreen-overlay js-fullscreen-overlay" id="fullscreen_overlay">
  <div class="fullscreen-container js-fullscreen-container">
    <div class="textarea-wrap">
      <textarea name="fullscreen-contents" id="fullscreen-contents" class="js-fullscreen-contents" placeholder="" data-suggester="fullscreen_suggester"></textarea>
          <div class="suggester-container">
              <div class="suggester fullscreen-suggester js-navigation-container" id="fullscreen_suggester"
                 data-url="/trentrichardson/jQuery-Timepicker-Addon/suggestions/commit">
              </div>
          </div>
    </div>
  </div>
  <div class="fullscreen-sidebar">
    <a href="#" class="exit-fullscreen js-exit-fullscreen tooltipped leftwards" title="Exit Zen Mode">
      <span class="mega-octicon octicon-screen-normal"></span>
    </a>
    <a href="#" class="theme-switcher js-theme-switcher tooltipped leftwards"
      title="Switch themes">
      <span class="octicon octicon-color-mode"></span>
    </a>
  </div>
</div>



    <div id="ajax-error-message" class="flash flash-error">
      <span class="octicon octicon-alert"></span>
      Something went wrong with that request. Please try again.
      <a href="#" class="octicon octicon-remove-close ajax-error-dismiss"></a>
    </div>

    
    <span id='server_response_time' data-time='0.07118' data-host='fe18'></span>
    
  </body>
</html>

