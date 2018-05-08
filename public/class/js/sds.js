function $(obj){
 return document.getElementById(obj);
}

var maxHeight=$("img").getElementsByTagName("ul")[0].getElementsByTagName("li").length*105;
//滚动图片的最大高度
var targety = 211;
//一次滚动距离
var dx;
var a=null;
function moveTop(){
 var le=parseInt($("img").scrollTop);
 if(le>211){
 targety=parseInt($("img").scrollTop)-211;
 }else{
 targety=parseInt($("img").scrollTop)-le-1;
 }
 scTop();
}
function scTop(){
 dx=parseInt($("img").scrollTop)-targety;
 $("img").scrollTop-=dx*.3;
 clearScroll=setTimeout(scTop,50);
 if(dx*.3<1){
 clearTimeout(clearScroll);
 }
}
function moveBottom(){
 var le=parseInt($("img").scrollTop)+211;
 var maxL=maxHeight-600;
 if(le<maxL){
 targety=parseInt($("img").scrollTop)+211;
 }else{
 targety=maxL
 }
 scBottom();
}
function scBottom(){
 dx=targety-parseInt($("img").scrollTop);
 $("img").scrollTop+=dx*.3;
 a=setTimeout(scBottom,50);
 if(dx*.3<1){
 clearTimeout(a)
 }
}