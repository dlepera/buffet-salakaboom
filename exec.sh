#!/bin/sh

# Comprimir JS do Projeto
for js in $( find aplicacao/js/ -name *.js | grep -iv "\-min.js$" ); do 
	java -jar /opt/yuicompressor-2.4.8.jar \
	--type js \
	--nomunge \
	--charset IBM855 \
	-o '.js$:-min.js' \
	$js \
; done

# Comprimir CSS do Projeto
for css in $( find aplicacao/css/ -name *.css | grep -iv "\-min.css$" ); do
	java -jar /opt/yuicompressor-2.4.8.jar \
	--type css \
       	--nomunge \
  	--charset IBM855 \
       	-o '.css$:-min.css' \
       	$css \
; done

 google-chrome http://localhost/framework/

