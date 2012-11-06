/* ********* drop down menu Java script code - start **********/

sfHover = function()
{
 var sfEls = document._over.getElementsByTagName("LI");
 
 for (var j=0; j<sfEls.length; j++)
 {
  sfEls[j].onmouseover=function()
  {
   this.className+=" sfhover";
  }
  sfEls[j].onmouseout=function()
  {
   this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
  }
 } 
}
if (window.attachEvent) window.attachEvent("onload", sfHover);
//–><!]]></script> // don’t need this line if using .JS file
 
/* ********* drop down menu Java script code – end  **********/
