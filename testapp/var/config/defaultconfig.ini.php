;<?php die(''); ?>
;for security reasons , don't remove or modify the first line

locale = "fr_FR"
charset = "UTF-8"

; see http://www.php.net/manual/en/timezones.php for supported values
timeZone = "Europe/Paris"

checkTrustedModules = off

; list of modules : module,module,module
trustedModules =

pluginsPath = lib:jelix-plugins/,app:plugins/
modulesPath = lib:jelix-modules/,app:modules/

theme = default

; for junittests module
enableTests = on


[plugins]
;nom = nom_fichier_ini

[responses]

[error_handling]
messageLogFormat = "%date%\t[%code%]\t%msg%\t%file%\t%line%\n"
logFile = error.log
email = root@localhost
emailHeaders = "Content-Type: text/plain; charset=UTF-8\nFrom: webmaster@yoursite.com\nX-Mailer: Jelix\nX-Priority: 1 (Highest)\n"
quietMessage="Une erreur technique est survenue. Désolé pour ce désagrément."

; mots clés que vous pouvez utiliser : ECHO, ECHOQUIET, EXIT, LOGFILE, SYSLOG, MAIL, TRACE
default      = ECHO EXIT
error        = ECHO EXIT
warning      = ECHO
notice       = ECHO
strict       = ECHO
; pour les exceptions, il y a implicitement un EXIT
exception    = ECHO



[compilation]
checkCacheFiletime  = on
force  = off

[urlengine]
; name of url engine :  "simple" or "significant"
engine        = simple

; enable the parsing of the url. Set it to off if the url is already parsed by another program
; (like mod_rewrite in apache), if the rewrite of the url corresponds to a simple url, and if
; you use the significant engine. If you use the simple url engine, you can set to off.
enableParser = on

multiview = off

; basePath corresponds to the path to the base directory of your application.
; so if the url to access to your application is http://foo.com/aaa/bbb/www/index.php, you should
; set basePath = "/aaa/bbb/www/". 
; if it is http://foo.com/index.php, set basePath="/"
; Jelix can guess the basePath, so you can keep basePath empty. But in the case where there are some
; entry points which are not in the same directory (ex: you have two entry point : http://foo.com/aaa/index.php 
; and http://foo.com/aaa/bbb/other.php ), you MUST set the basePath (ex here, the higher entry point is index.php so
; : basePath="/aaa/" )
basePath = ""


defaultEntrypoint= index

entrypointExtension= .php

notfoundAct = "jelix~error_notfound"

;indique si vous utilisez IIS comme serveur
useIIS = off

;indique le paramètre dans $_GET où est indiqué le path_info
IISPathKey = __JELIX_URL__

;indique si il faut stripslashé le path_info récupéré par le biais de IISPathKey
IISStripslashesPathKey = on

; liste des actions requerant https (syntaxe expliquée dessous), pour le moteur d'url simple
simple_urlengine_https = "unittest~urlsig_url8@classic @xmlrpc"

[simple_urlengine_entrypoints]
; paramètres pour le moteur d'url simple : liste des points d'entrées avec les actions
; qui y sont rattachées

; nom_script_sans_suffix = "liste de selecteur séparé par un espace"
; selecteurs :
;   m~a@r    -> pour action a du module m répondant au type de requete r
;   m~*@r    -> pour toute action du module m répondant au type de requete r
;   @r       -> toute action de tout module répondant au type de requete r

index = "@classic"
xmlrpc = "@xmlrpc"
jsonrpc = "@jsonrpc"
testnews = "jelix_tests~urlsig_url2@classic jelix_tests~urlsig_url3@classic"
foo/bar = "jelix_tests~urlsig_url4@classic"
news = "new~*@classic"

__https=

[logfiles]
default=messages.log


[acl]
driver = db