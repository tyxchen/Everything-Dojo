document.onready=function(){"use strict";function e(){for(var e=[s.el,a.el,r.el,i.el],t=0;t<e.length;t++)if(/invalid/.test(e[t].className)||!e[t].value)return!1;return o.el.checked?!0:!1}function t(){e()?d.removeAttribute("disabled"):d.setAttribute("disabled",!0)}var n,s=new Message("[name='user_name']"),a=new Message("[name='usr_email']"),r=new Message("[name='pwd']"),i=new Message("[name='pwd2']"),o=new Message("[name='tos']"),l=new XMLHttpRequest,d=document.getElementById("doRegister");s.el.onkeyup=function(e){var a=s.el.value,r="which"in e?e.which:e.keyCode;(r>47&&60>r||r>64&&91>r||r>95&&112>r||r>185&&193>r||r>218&&223>r||32==r||8==r||13==r||46==r)&&(/^[a-z\d_]{3,20}$/i.test(a)?(clearTimeout(n),s.purge(),s.el.parentNode.lastElementChild.style.display="inline",l.onreadystatechange=function(){4==l.readyState&&(200==l.status?"success"==l.responseText?(s.assign("Username is valid.","correct").show(),t(),s.el.parentNode.lastElementChild.style.display="none"):"error"==l.responseText&&(s.assign("Username already exists! Please choose a new one.","error").show(),d.setAttribute("disabled",!0),s.el.parentNode.lastElementChild.style.display="none"):0!==l.status&&(s.assign("A "+l.status+" error occurred. Please try again.","error").show(),d.setAttribute("disabled",!0),s.el.parentNode.lastElementChild.style.display="none"))},n=setTimeout(function(){try{l.open("GET","register.php?username="+a,!0),l.setRequestHeader("X-Requested-With","XMLHttpRequest"),l.send()}catch(e){window.alert("An AJAX error occured. Please check your internet connection and try again."),window.evdoDebug===!0&&console.log("Error: "+e)}},100)):(clearTimeout(n),l.abort(),s.assign("Invalid username. Usernames must be 3-20 characters long and can only contain alphanumeric characters and underscores.","error").show(),s.el.parentNode.lastElementChild.style.display="none",d.setAttribute("disabled",!0)))},a.el.onkeyup=function(e){var n=a.el.value,s="which"in e?e.which:e.keyCode;(s>47&&60>s||s>64&&91>s||s>95&&112>s||s>185&&193>s||s>218&&223>s||32==s||8==s||13==s||46==s)&&(/^\S+@(localhost|([\w\d-]{2,}\.){1,2}[a-z]{2,6})$/i.test(n)?(a.purge(),t()):(a.assign("Email entered is not a valid email.","error").show(),d.setAttribute("disabled",!0)))},r.el.onkeyup=i.el.onkeyup=function(){var e=r.el.value,n=i.el.value;e.length<6?r.assign("Passwords must be at least 6 characters long","error").show():e!=n?(i.assign("Passwords do not match.","error").show(),d.setAttribute("disabled",!0)):(r.purge(),i.purge(),t())},o.el.onchange=function(){o.el.checked?(o.el.setAttribute("value","yes"),t()):d.setAttribute("disabled",!0)},s.el.onpaste=function(){s.el.onkeyup({which:8,keyCode:8})},a.el.onpaste=function(){a.el.onkeyup({which:8,keyCode:8})},s.el.onblur=function(){s.hide()},a.el.onblur=function(){a.hide()},r.el.onblur=function(){r.hide()},i.el.onblur=function(){i.hide()},function(e){var t=e("[name='regForm']"),n=e("[name='doRegister']"),l=new Message("#message");t.attr("onsubmit","return false;").removeAttr("action"),e("[name='ajax']").val(!0),n.attr("type","button"),n.click(function(){e.ajax({type:"POST",url:"register.php",data:e("[name='regForm']").serialize(),beforeSend:function(){d.setAttribute("disabled",!0),l.purge(),n.next().css({display:"inline",left:"4rem",top:"0"})},success:function(t){setTimeout(function(){-1!==t.indexOf("r")&&(l.assign("Recaptcha failed! Please try again.","error").show(function(){l.el.nextElementSibling.style.bottom="1em",l.el.nextElementSibling.style.left="325px"}),d.removeAttribute("disabled")),-1!==t.indexOf("n")&&s.assign("Username is not a valid username.","error").show(),-1!==t.indexOf("e")&&a.assign("Email is not a valid email.","error").show(),-1!==t.indexOf("u")&&s.assign("Username already exists in database.","error").show(),-1!==t.indexOf("a")&&a.assign("Email already exists in database.","error").show(),-1!==t.indexOf("p")&&(r.assign("Passwords did not meet the requirements or did not match.","error").show(),i.assign("Passwords did not meet the requirements or did not match.","error").show()),-1!==t.indexOf("t")&&o.assign("Please agree to the Terms of Service before continuing","error").show(),-1!==t.indexOf("s")&&e("#content").animate({opacity:0},500,function(){e(this).css("opacity",1).html("<p>Thank you; your registration is now complete. After activation, you can login <a href='login.php'>here</a>.</p>")}),n.next().css("display",""),Recaptcha.reload()},1e3)}})})}(jQuery)};
