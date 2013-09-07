<?php $config =&get_config();?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Page Not Found :(</title>
        <style>
            html, body { width: 100%; height: 100%; margin: 0; padding: 0; }
        	.candy { position: absolute; top: 50%; left: 50%; width: 400px; height: 400px; margin-left: -200px; margin-top: -200px; }
        	.shadow { text-align: center; }
            .shadow img{ width: 446px; height: 446px; }
            .candy-img { position: absolute; top: 0; left: 0; z-index: 100; width: 416px; height: 416px; background: url(<?=$config['base_url'];?>img/candy.png); }
            .delicate-design-stroke { display: block; width: 70px; margin: 0 auto 2em; border-bottom: 5px solid #9a092b; }
            .error { font: 700 26px/43px "proxima-nova", sans-serif; text-transform: uppercase; margin: .5em auto .8em; }
            span a { border-bottom: 1px solid transparent; text-decoration: none; color: #555; text-transform: uppercase; font: 13px "myriad-pro", sans-serif; transition: all .8s ease;
					-webkit-transition: all .8s ease;
					-moz-transition: all .8s ease;
					-o-transition: all .8s ease;
					-ms-transition: all .8s ease;
 			}
 			span a:hover { border-color: #555; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="candy">
            	<div class="shadow">
            		<img src="img/candy_shadow.png">
            		<div class="error">404. Страница не найдена</div>
            		<div class="delicate-design-stroke"> </div>
            		<span><a href="<?=$config['base_url'];?>">вернуться на главную</a></span>
            	</div>
            	<div class="candy-img"></div>
            	</div>
            </div>
        </div>
    </body>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
    	$(document).ready( function(){
    		var $elem = $('.candy-img'),
    		    degree = 0,
    		    timer;
    		function rotate(elem) {
    			$elem.css({ '-moz-transform': 'rotate(' + degree + 'deg)' });
    			$elem.css({ '-webkit-transform': 'rotate(' + degree + 'deg)' });
    			$elem.css({ '-o-transform': 'rotate(' + degree + 'deg)' });
    			$elem.css({ '-ms-transform': 'rotate(' + degree + 'deg)'});
    			timer = setTimeout(function() {
		            ++degree; 
		            rotate();
		        },5);
    		};
    		rotate();
    	});
    </script>
    <!-- Loading typekit-->
    <script type="text/javascript" src="//use.typekit.net/iqb6oel.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</html>
