/* jshint browser:true */
/* global Message:false */

/**
 * Provides field validation to register.php
 */

document.onready = function () {

  "use strict";

  /**
   * Set variables
   */

  // Messages
  var userName   = new Message("[name='user_name']"),
      userEmail  = new Message("[name='usr_email']"),
      userPwd    = new Message("[name='pwd']"),
      userPwdVal = new Message("[name='pwd2']");

  // Timeouts
  var userTimeout,
      emailTimeout;

  // AJAX stuff
  var ajaxName  = new XMLHttpRequest(),
      ajaxEmail = new XMLHttpRequest();

  // Submit button
  var submit = document.getElementById("doRegister");

  /**
   * Validation
   */

  // Username
  userName.el.onkeyup = function (e) {
    var user    = userName.el.value,
        keycode = ('which' in e) ? e.which : e.keyCode; // key validation

    if ((keycode > 47 && keycode < 60) || (keycode > 64 && keycode < 91) || (keycode > 95 && keycode < 112) || (keycode > 185 && keycode < 193) || (keycode > 218 && keycode < 223) || keycode == 32 || keycode == 8 || keycode == 13 || keycode == 46) {
      if (!/^[a-z\d_]{3,20}$/i.test(user)) {
        clearTimeout(userTimeout);
        ajaxName.abort(); // abort ajax request if already sent
        userName.assign("Invalid username. Usernames must be 3-20 characters long and can only contain alphanumeric characters and underscores.", "error").show();
        userName.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
        submit.setAttribute("disabled", true);
      } else {
        clearTimeout(userTimeout);
        ajaxEmail.abort();
        userName.purge();
        userName.el.parentNode.lastElementChild.style.display = "inline"; // show loading gif
        // ajax to verify username
        ajaxName.onreadystatechange = function () {
          if (ajaxName.readyState == 4 ) {
            if (ajaxName.status == 200) {
              if (ajaxName.responseText == "success") {
                userName.assign("Username is valid.", "correct").show();
                toggleSubmitDisabled();
              } else if (ajaxName.responseText == "error") {
                userName.assign("Username already exists! Please choose a new one.", "error").show();
                submit.setAttribute("disabled", true);
              }
            } else {
              userName.assign("A " + ajaxName.status + " error occurred. Please try again.", "error").show();
              submit.setAttribute("disabled", true);
            }
            userName.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
          }
        };

        // set 400ms timeout because we're getting results too fast, and
        // users won't know whether the AJAX got through or not :P
        userTimeout = setTimeout(function () {
          try {
            ajaxName.open("GET", "register.php?username=" + user, true);
            ajaxName.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            ajaxName.send();
          } catch (error) {
            throw new Error("An AJAX error occured:" + error);
          }
        }, 300);
      }
    }
  };

  // Email
  userEmail.el.onkeyup = function (e) {
    var email   = userEmail.el.value,
        keycode = ('which' in e) ? e.which : e.keyCode; // key validation

    if ((keycode > 47 && keycode < 60) || (keycode > 64 && keycode < 91) || (keycode > 95 && keycode < 112) || (keycode > 185 && keycode < 193) || (keycode > 218 && keycode < 223) || keycode == 32 || keycode == 8 || keycode == 13 || keycode == 46) {
      if (!/^\S+@(localhost|([\w\d-]{2,}\.){1,2}[\w]{2,6})$/i.test(email)) {
        clearTimeout(emailTimeout);
        ajaxEmail.abort();
        userEmail.assign("Email entered is not a valid email.", "error").show();
        userEmail.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
        submit.setAttribute("disabled", true);
      } else {
        clearTimeout(emailTimeout);
        ajaxEmail.abort();
        userEmail.purge();
        userEmail.el.parentNode.lastElementChild.style.display = "inline"; // show loading gif
        // ajax to verify email
        ajaxEmail.onreadystatechange = function () {
          if (ajaxEmail.readyState == 4 ) {
            if (ajaxEmail.status == 200) {
              if (ajaxEmail.responseText == "success") {
                userEmail.assign("Email is valid.", "correct").show();
                toggleSubmitDisabled();
              } else if (ajaxEmail.responseText == "error") {
                userEmail.assign("Email address already exists in our database! Please do not create multis.", "error").show();
                submit.setAttribute("disabled", true);
              }
            } else {
              userEmail.assign("A " + ajaxEmail.status + " error occurred. Please try again.", "error").show();
              submit.setAttribute("disabled", true);
            }
            userEmail.el.parentNode.lastElementChild.style.display = "none"; // hide loading gif
          }
        };

        // set 400ms timeout for same reasons as with username
        emailTimeout = setTimeout(function () {
          try {
            ajaxEmail.open("GET", "register.php?email=" + email, true);
            ajaxEmail.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            ajaxEmail.send();
          } catch (error) {
            throw new Error("An AJAX error occured:" + error);
          }
        }, 300);
      }
    }
  };

  // Passwords
  userPwd.el.onkeyup = userPwdVal.el.onkeyup = function () {
    var original = userPwd.el.value,
        verify   = userPwdVal.el.value;
    if (original.length < 6) {
      userPwd.assign("Passwords must be at least 6 characters long", "error").show();
    } else if (original != verify) {
      userPwdVal.assign("Passwords do not match.", "error").show();
      submit.setAttribute("disabled", true);
    } else {
      userPwd.purge();
      userPwdVal.purge();
      toggleSubmitDisabled();
    }
  };

  /**
   * Validate on paste
   *
   * Arguments passed to onkeyup are an ugly hack to trigger key validation
   * In this case, 8 is just an arbitrary keycode.
   *
   * And yes, I know onpaste is nonstandard.
   */
  userName.el.onpaste = function () {
    userName.el.onkeyup({"which": 8, "keyCode": 8});
  };

  userEmail.el.onpaste = function () {
    userEmail.el.onkeyup({"which": 8, "keyCode": 8});
  };

  /**
   * Onblur effects
   */
  userName.el.onblur = function () {
    userName.hide();
  };

  userEmail.el.onblur = function () {
    userEmail.hide();
  };

  userPwd.el.onblur = function () {
    userPwd.hide();
  };

  userPwdVal.el.onblur = function () {
    userPwdVal.hide();
  };

  /**
   * Functions
   */
  function validateFinal () {
    var list = [userName.el, userEmail.el, userPwd.el, userPwdVal.el];
    for (var i = 0; i < list.length; i++) {
      if (/invalid/.test(list[i].className) || !list[i].value) {
        return false;
      }
    }
    return true;
  }

  function toggleSubmitDisabled () {
    if (!validateFinal()) {
      submit.setAttribute("disabled", true);
    } else {
      submit.removeAttribute("disabled");
    }
  }

};
