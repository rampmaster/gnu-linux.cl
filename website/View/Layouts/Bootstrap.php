<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Design by http://delaf.cl -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="generator" content="SowerPHP"/>
    <title><?= $_header_title ?></title>
    <link rel="shortcut icon" href="<?= $_base ?>/img/favicon.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= $_base ?>/assets/css/style.css"/>

    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?= $_base ?>/bootstrap/img/favicon.ico">
    <link rel="apple-touch-icon" href="<?= $_base ?>/bootstrap/img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $_base ?>/bootstrap/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= $_base ?>/bootstrap/img/apple-touch-icon-114x114.png">

    <!-- CSS code from Bootply.com editor -->

    <style type="text/css">

    </style>
</head>
<body>
<header class="navbar navbar-default navbar-fixed-top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand"><?= $_body_title ?></a>
        </div>
        <nav class="collapse navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
                <?php
                $links = array();
                foreach ($_nav_website as $link => &$name) {
                    if ($link[0] == '/') $link = $_base . $link;
                    if (is_array($name)) echo '<li><a href="' . $link . '" title="' . $name['title'] . '">' . $name['name'] . '</a></li>';
                    else echo '<li><a href="' . $link . '">' . $name . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</header>
<div id="masthead">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>GNU-Linux Chile
                    <p class="lead">Tu portal de información sobre GNU y Linux</p>
                </h1>
            </div>
            <div class="col-md-5">
                <div class="well well-lg">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="http://www.flisol.info/QueEs?action=AttachFile&do=get&target=banner2014.png" class="img-responsive">
                        </div>
                        <div class="col-sm-6">
                            Some text here
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /cont -->
</div>
<!-- Begin Body -->
<div class="container">
    <div class="row">
        <!-- CONTENIDO PRINCIPAL -->
        <?php
        $message = \sowerphp\core\Model_Datasource_Session::message();
        if ($message) echo '<div class="session_message">', $message, '</div>';
        echo $_content;
        ?>
        <!-- FIN DEL CONTENIDO PRINCIPAL -->
    </div>
    <div class="row">
        <div class="col-md-9 col-md-offset-3">
            <hr>
            <h4>
                <small><?= (is_array($_footer) ? implode(' ', $_footer) : $_footer), "\n" ?></small>
            </h4>
            <hr>
        </div>
    </div>
</div>

<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


<script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

<!-- JavaScript jQuery code from Bootply.com editor  -->

<script type='text/javascript'>

    $(document).ready(function () {

        $('#sidebar').affix({
            offset: {
                top: 235
            }
        });

        var $body = $(document.body);
        var navHeight = $('.navbar').outerHeight(true) + 10;

        $body.scrollspy({
            target: '#leftCol',
            offset: navHeight
        });

        /* smooth scrolling sections */
        $('a[href*=#]:not([href=#])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - 50
                    }, 1000);
                    return false;
                }
            }
        });

    });

</script>


</body>
</html>

