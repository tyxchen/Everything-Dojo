/* Polyfills / enhancements */
if (!String.prototype.startsWith) {
  Object.defineProperty(String.prototype, 'startsWith', {
    enumerable: false,
    configurable: false,
    writable: false,
    value: function (searchString, position) {
      position = position || 0;
      return this.lastIndexOf(searchString, position) === position;
    }
  });
}

if (!String.prototype.trim) {
  (function(){
    // Make sure we trim BOM and NBSP
    var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    String.prototype.trim = function () {
      return this.replace(rtrim, "");
    };
  })();
}

/* Taken from http://www.sitepoint.com/trimming-strings-in-javascript/ */
String.prototype.trimLeft = function(charlist) {
  if (charlist === undefined)
    charlist = "\\s";

  return this.replace(new RegExp("^[" + charlist + "]+"), "");
};

/* End polyfills / enhancements */

function contains(needle, haystack) {
  return haystack.indexOf(needle) > -1;
}

function containsAny(needle, haystack) {
  var words = needle.split(" ");

  for (var i = 0; i < words.length; i ++) {
    if (contains(words[i], haystack)) {
      return true;
    }
  }

  return false;
}

function parseSearch(query) {
  query = query.toLowerCase().trim(); // Searches are case-insensitive and ignore leading and trailing whitespace

  var tokens = query.split(" ");

  var searchTerms = [],
      creatorTerms = [],
      versionTerms = [],
      requiredTerms = [],
      forbiddenTerms = [];

  tokens.forEach(function (token) {
    switch (token.charAt(0)) {
      case "@":
        creatorTerms.push(token.slice(1)); // Trim the @ and add to the list of creators searched for
        break;

      case "#":
        versionTerms.push(token.slice(1)); // Trim the # and add to the list of versions searched for
        break;

      case "+":
        requiredTerms.push(token.slice(1)); // Trim the + and add to the list of required words searched for
        break;

      case "-":
        forbiddenTerms.push(token.slice(1)); // Trim the - and add to the list of forbidden words searched for
        break;

      case "\\":
        var escaped = (function countBackslashes(input) {
          if (input.charAt(0) === "\\") {
            return 1 + countBackslashes(input.slice(1));
          }

          else {
            return 0;
          }
        })(token) % 2 !== 0; // Recursive anonymous function hack to check if the number of backslashes is even or odd

        token.trimLeft("\\"); // Remove the backslashes from the start of the string, we don't care about them any more

        if (escaped) {
          switch (token.charAt(0)) { // A wild recursive switch appeared!
            case "@":
              creatorTerms.push(token.slice(1)); // Trim the @ and add to the list of creators searched for
              break;

            case "#":
              versionTerms.push(token.slice(1)); // Trim the # and add to the list of versions searched for
              break;

            case "+":
              requiredTerms.push(token.slice(1)); // Trim the + and add to the list of required words searched for
              break;

            case "-":
              forbiddenTerms.push(token.slice(1)); // Trim the - and add to the list of forbidden words searched for
              break;

            default:
              searchTerms.push(token);
          }

          break;
        }

        break;

      default:
        searchTerms.push(token);
    }
  });

  return {"search": searchTerms, "creator": creatorTerms, "version": versionTerms, "required": requiredTerms, "forbidden": forbiddenTerms};
}

$(document).ready(function () {
  var search = $(".search");

  search.on("propertychange keyup input paste", function () {
    $(".style").each(function () {
      var query = parseSearch(search.val());

      var mainText = $(this).children().first().text().toLowerCase();
      var stage = $(this).children().last().text().toLowerCase();
      var author = $(this).children().first().next().text().toLowerCase();

      // Creator filter
      var creators = query.creator;

      var creatorMatch = false;

      if (creators !== []) {
        creators.some(function (c) {
          if (contains(c, author)) {
            creatorMatch = true;
            return false;
          }

          return creatorMatch; // creatorMatch is true if a match has been found, and Array.prototype.some() stops if the callback returns true
        });
      }

      else {
        creatorMatch = true; // If no creators were specified, then the overall match shouldn't fail
      }

      // Release stage filter
      var versions = query.version;

      var versionMatch = false;

      if (versions !== []) {
        versions.some(function (v) {
          if (contains(v, stage)) {
            versionMatch = true;
            return false;
          }

          return versionMatch; // versionMatch is true if a match has been found, and Array.prototype.some() stops if the callback returns true
        });
      }

      else {
        versionMatch = true; // If no versions were specified, then the overall match shouldn't fail
      }

      // Required word filter
      var requireds = query.required;

      var requiredMatch = false;

      if (requireds !== []) {
        requireds.some(function (c) {
          if (contains(c, mainText)) {
            requiredMatch = true;
            return false;
          }

          return requiredMatch; // requiredMatch is true if a match has been found, and Array.prototype.some() stops if the callback returns true
        });
      }

      else {
        requiredMatch = true; // If no required words were specified, then the overall match shouldn't fail
      }

      // Forbidden word filter
      var forbiddens = query.forbidden;

      var forbiddenMatch = false;

      if (forbiddens !== []) {
        forbiddens.some(function (c) {
          if (contains(c, mainText)) {
            forbiddenMatch = true;
            return false;
          }

          return forbiddenMatch; // forbiddenMatch is true if a match has been found, and Array.prototype.some() stops if the callback returns true
        });
      }

      else {
        forbiddenMatch = true; // If no forbidden words were specified, then the overall match shouldn't fail
      }


      if (! (containsAny(query, mainText) && creatorMatch && versionMatch && requiredMatch && forbiddenMatch)) {
        $(this).fadeOut();
      }

      else {
        $(this).fadeIn();
      }

      $(this).children().first().unhighlight({"element": "mark"}); // Unhighlight any leftover matches from last time around as they mess up the highlighting method
      $(this).children().first().highlight(query.split(" "), {"element": "mark"}); // Highlight matches
    });
  });

  // Search box focusing/defocusing
  search.keypress(function (key) {
    if (key.which == 13) {
      $(this).blur();
    }
  });

  /* jQuery handler toggle. Stolen from the jquery-migrate source (https://github.com/jquery/jquery-migrate/blob/792408c201833b8a8b62405980938262b09876dc/src/event.js). */
  jQuery.fn.toggleHandler = function( fn, fn2 ) {
    // Don't mess with animation or css toggles
    if ( !jQuery.isFunction( fn ) || !jQuery.isFunction( fn2 ) ) {
      return oldToggle.apply( this, arguments );
    }

    // Save reference to arguments for access in closure
    var args = arguments,
    guid = fn.guid || jQuery.guid++,
    i = 0,
    toggler = function( event ) {
      // Figure out which function to execute
      var lastToggle = ( jQuery._data( this, "lastToggle" + fn.guid ) || 0 ) % i;
      jQuery._data( this, "lastToggle" + fn.guid, lastToggle + 1 );
      // Make sure that clicks stop
      event.preventDefault();
      // and execute the function
      return args[ lastToggle ].apply( this, arguments ) || false;
    };
    // link all the functions, so any of them can unbind this click handler
    toggler.guid = guid;
    while ( i < args.length ) {
      args[ i++ ].guid = guid;
    }
    return this.click( toggler );
  };

  $(".icon-box").toggleHandler(function () {
    $(search).focus();
  }, function () {
    $(search).blur();
  });
});
