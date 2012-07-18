// ***************************************************************************
// Copyright 2007 - 2008 Tavs Dokkedahl
// Contact: http://www.jslab.dk/contact.php
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//              
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
// ***************************************************************************

/*********************************************
*
*   Safari Search v. 1.0
*   More info at http://www.jslab.dk/scripts.safari.search.php
*
**********************************************/

// Namespace
if (!window.JSL)
  JSL = {};

// Options

// Show toolbar on load. If false the toolbar is
// displayed when pressing CTRL + ALT + f
// Default is true
JSL.SHOW_ON_LOAD = false;

// Root element to search from. String is eval'ed
// so you can use any method you want to designate
// the element to search in. You can also change the
// root at run time.
// Default is document.documentElement.childNodes[1] (document.body)
JSL.ROOT = 'document.getElementById("vslist")';

// Tags which should never be searched (besides those which can
// not have child nodes). input/textarea tags are not supported
// very well except for IE.
// Default is ['script','textarea','input']
JSL.IGNORE_TAGS = ['script','textarea','input'];

// Max. number of results for any search. The higher the number
// the slower the script will work.
// Set to 0 for no limit
// Default is 100
JSL.MAX_RESULTS = 100;

// Color of transparent overlay. If you have a very dark website
// with a black background color you could change it to white
// ('#fff') for instance.
// Default value is '#000'
JSL.OVERLAY_COLOR = '#000';

// Opacity of overlay. Values are in the range [0,1] where 0
// is fully transparent and 1 is no transparency.
// Default value is 0.35
JSL.OVERLAY_OPACITY = 0;

// Starting zIndex for elements added by this program. This
// value should at least be 1 higher than the element in
// your document with the highest zIndex.
// Default is 100
JSL.Z_INDEX = 100;

// Delay in milliseconds to wait for input completion
// before starting search. There is no reason to perform a
// search before the users makes a pause in inputting.
// Toggling case-sensitve or regex will always start a new
// search immediately
// Set to 0 to do real time searching
// Default value is 250
JSL.DELAY = 250;

/*** No configurable options below this line ***/

// Detect IE 6 to work around position:fixed
/*@cc_on
@if (@_jscript_version <= 5.6)
  JSL.IE6 = true;
/*@end @*/

// Current keyword
JSL.KW = '';
// Current keyword as regex
JSL.KW_RGX = new RegExp(JSL.KW,'im');

// Global ref. to toolbar
JSL.bar = null; 

// Current set of matches
JSL.matches = [];

// Current set of matching nodes
JSL.nodes = [];

// Get absolute position of element
HTMLElement.prototype.getPosition =
  function(scroll) {
    var o;
    // If scrollOffset should be taken into consideration
    if (scroll) {
       // If Firefox, Opera, Safari else IE
       o = window.pageXOffset != undefined ? {x:window.pageXOffset, y:window.pageYOffset} : {x:document.documentElement.scrollLeft, y:document.documentElement.scrollTop};
    }
    else
      o = {x:0,y:0};
    var n = this;
    // Until element have no parent
    do {
      o.x += n.offsetLeft;
      o.y += n.offsetTop;
      n = n.offsetParent;
    }
    while(n)
      return o;
  };

// Non-recusive preorder traversal (depth first)
HTMLElement.prototype.getTextNodes =
  function() {
    var a = [];
    var n = this;
    var tmp = /^\s*$/;
    while(n) {
      // If node have already been visited
      if (n.v) {
        // Remove mark for visited nodes
        n.v = false;
        // Once we reach the root element again traversal
        // is done and we can break
        if (n == this)
          break;
        if (n.nextSibling)
          n = n.nextSibling;
        else
          n = n.parentNode;
      }
      // else do somthing with node
      else {
        // If node is a textnode and matches the keyword. Never match empty text nodes (does not always work in IE for unkown reasons)
        if (n.nodeType == 3 && !/^\s*$/.test(n.nodeValue) && JSL.KW_RGX.test(n.nodeValue)) {
          a.push(n);
          // If we have reached JSL.MAX_RESULTS just break
          /*
          For mysterious reasons this line breaks the search.
          If you can figure out why please let me know.
          if (a.length >= JSL.MAX_RESULTS) {
            break;
          }
          */
        }
        // If node has childnodes then we mark this node as
        // visited as we are sure to be back later
        // Don't follow nodes which are on ignore list
        if (n.firstChild && n != JSL.bar && !JSL.IGNORE_TAGS.test(n.nodeName)) {
          n.v = true;
          n = n.firstChild;
        }
        else if (n.nextSibling)
          n = n.nextSibling;
        else
          n = n.parentNode;
      }
    }
    return a;
  };

// Create the toolbar
// Mostly just boring element creation.
JSL.createToolbar =
  function() {
    // Set global ref to toolbar
    JSL.bar = document.createElement('div');
    // Set CSS style
    if (!JSL.IE6)
      JSL.bar.style.position = 'fixed';
    // Ugly fix for IE 6 for position:fixed
    else {
      JSL.bar.style.position = 'absolute';
      window.onscroll =
        function() {
          JSL.bar.style.top = document.documentElement.scrollTop + 'px';
        };
    }
    // Min-width to avoind floating boxes wrapping lines
    JSL.bar.style.minWidth = '750px';
    JSL.bar.style.top = 0;
    JSL.bar.style.width = '100%';
    JSL.bar.style.zIndex = JSL.Z_INDEX + 3;
    // Customizable CSS properties - maybe they should be server side generated 
    JSL.bar.style.fontSize = '11px';
    JSL.bar.style.fontFamily = 'Tahoma, sans-serif';
    JSL.bar.style.padding = '4px';
    JSL.bar.style.backgroundColor = '#d4d0c8';
    JSL.bar.style.borderBottom = '1px solid #404040';
    // Container for holding search inputs
    // Use a fieldset to pass W3C validator for XHTML
    var conLeft = document.createElement('fieldset');
    // Style for left container
    conLeft.style.cssFloat = 'left';
    conLeft.style.width = '90%';
    conLeft.style.fontSize = '11px';
    conLeft.style.fontFamily = 'Tahoma, sans-serif';
    // Close button
    var input = document.createElement('input');
    input.type = 'button';
    input.value = 'Close';
    input.title = 'Close toolbar (Esc)';
    input.style.fontSize = '11px';
    input.style.marginRight = '8px';
    input.style.verticalAlign = 'middle';
    input.onclick = JSL.closeToolbar;
    conLeft.appendChild(input);
    conLeft.appendChild(document.createTextNode('Find on this page: '));
    // Keyword input
    JSL.bar.kw = document.createElement('input');
    JSL.bar.kw.style.fontSize = '11px';
    JSL.bar.kw.style.margin = '0 4px';
    JSL.bar.kw.style.verticalAlign = 'middle';
    JSL.bar.kw.onkeyup = JSL.getKW;
    conLeft.appendChild(JSL.bar.kw);
    // Number of results
    JSL.bar.numResults = document.createElement('span');
    JSL.bar.numResults.appendChild(document.createTextNode('0 results'));
    conLeft.appendChild(JSL.bar.numResults);
    // Previous button
    JSL.bar.prev = document.createElement('input');
    JSL.bar.prev.type = 'button';
    // Left arrow quote
    JSL.bar.prev.value = '\xab';
    JSL.bar.prev.style.fontSize = '11px';
    JSL.bar.prev.style.margin = '0 4px';
    JSL.bar.prev.style.verticalAlign = 'middle';
    JSL.bar.prev.disabled = true;
    JSL.bar.prev.title = 'Previous result (Ctrl + Alt + p)';
    JSL.bar.prev.onclick = function(e) {JSL.next(-1);};
    conLeft.appendChild(JSL.bar.prev);
    // Next button
    JSL.bar.next = document.createElement('input');
    JSL.bar.next.type = 'button';
    // Right arrow quote
    JSL.bar.next.value = '\xbb';
    JSL.bar.next.style.fontSize = '11px';
    JSL.bar.next.style.marginRight = '4px';
    JSL.bar.next.style.verticalAlign = 'middle';
    JSL.bar.next.disabled = true;
    JSL.bar.next.title = 'Next result (Ctrl + Alt + n)';
    JSL.bar.next.onclick = function(e) {JSL.next(1);};
    conLeft.appendChild(JSL.bar.next);
    // Case sensitive checkbox
    JSL.bar.usecase = document.createElement('input');
    JSL.bar.usecase.type = 'checkbox';
    JSL.bar.usecase.style.marginRight = '4px';
    JSL.bar.usecase.id = 'case';
    JSL.bar.usecase.title = 'Ctrl + Alt + c';
    JSL.bar.usecase.onclick = JSL.toggleCase;
    conLeft.appendChild(JSL.bar.usecase);
    // Label for case sensitive
    var label = document.createElement('label');
    label.htmlFor = 'case';
    label.title = 'Toggle case sensitivity (Ctrl + Alt + c)';
    label.style.marginRight = '4px';
    label.appendChild(document.createTextNode('Case-sensitive'));
    conLeft.appendChild(label);
    // Regex checkbox
    JSL.bar.rgx = document.createElement('input');
    JSL.bar.rgx.type = 'checkbox';
    JSL.bar.rgx.style.marginRight = '4px';
    JSL.bar.rgx.id = 'regex';
    JSL.bar.rgx.title = 'Ctrl + Alt + r';
    JSL.bar.rgx.onclick = JSL.toggleRegex;
    conLeft.appendChild(JSL.bar.rgx);
    // Label for regex
    label = document.createElement('label');
    label.htmlFor = 'regex';
    label.title = 'Toggle regex (Ctrl + Alt + r)';
    label.appendChild(document.createTextNode('Regular expression'));
    conLeft.appendChild(label);
    // Add left container to toolbar
    // Please leave this logo/link to credit my work.
    JSL.bar.appendChild(conLeft);
    // Create right continer holding JSLab logo
    var conRight = document.createElement('div');
    conRight.style.cssFloat = 'right';
    conRight.style.marginRight = '0.8em';
    // JSLab logo/link
    var img = document.createElement('img');
    img.alt = 'Created by Tavs Dokkedahl @ JSLab.dk. Click for more info';
    img.title = 'Created by Tavs Dokkedahl @ JSLab.dk. Click for more info';
    img.src = 'http://www.jslab.dk/gfx/logo.jpg';
    img.style.borderTop = img.style.borderLeft = '1px solid #fff';
    img.style.borderBottom = img.style.borderRight = '1px solid #404040';
    img.style.cursor = 'pointer';
    img.onclick = function() {window.open('http://www.jslab.dk/scripts.safari.search.php','','');};
    conRight.appendChild(img);
    // Append right container to toolbar
    JSL.bar.appendChild(conRight);
    // Create div for clearing floats
    var clear = document.createElement('div');
    clear.style.clear = 'both';
    JSL.bar.appendChild(clear);
  };

// Create overlay
JSL.createOverlay =
  function() {
    JSL.overlay = document.createElement('div');
    // Match width/height to root element of search.
    // if body is root cover entire page otherwise just cover target area
    if (JSL.ROOT == document.documentElement.childNodes[1]) {
      JSL.overlay.style.height = JSL.ROOT.offsetHeight + JSL.bar.offsetHeight + 'px';
    }
    else {
      JSL.overlay.style.height = JSL.ROOT.offsetHeight + 'px';
      JSL.overlay.style.border = '1px solid #000';
    }
    JSL.overlay.style.backgroundColor = JSL.OVERLAY_COLOR;
    JSL.overlay.style.position = 'absolute';
    var p = JSL.ROOT.getPosition();
    JSL.overlay.style.left = p.x + 'px';
    JSL.overlay.style.top = p.y + 'px';
    JSL.overlay.style.opacity = JSL.OVERLAY_OPACITY;
    JSL.overlay.style.zIndex = JSL.Z_INDEX;
  };

// Maybe this function can be avoided using some CSS.
// Used to redraw the overlay to cover entire search region
// if region is resized. Using width of 100% will not
// work in every case.
JSL.resizeOverlay =
  function(e) {
    // Reset width to 0 to get proper scrollWidth
    JSL.overlay.style.width = 0;
    // If root is body element
    if (JSL.ROOT == document.documentElement.childNodes[1])
      JSL.overlay.style.width = document.documentElement.scrollWidth + 'px';
    else
      JSL.overlay.style.width = JSL.ROOT.scrollWidth + 'px';
  };

// Show/hide overlay
JSL.toggleOverlay =
  function(show) {
    if (show) {
      // Insert overlay
      JSL.ROOT.insertBefore(JSL.overlay, JSL.ROOT.firstChild);
      // If root is body element
      if (JSL.ROOT == document.documentElement.childNodes[1])
        JSL.overlay.style.width = document.documentElement.scrollWidth + 'px';
      else
        JSL.overlay.style.width = JSL.ROOT.scrollWidth + 'px';
      // Redraw overlay on resize
      window.addEventListener('resize', JSL.resizeOverlay, true);
      // Add shortcuts
      document.addEventListener('keydown', JSL.searchShortcuts, true);
      // Remove results when viewport is clicked
      document.addEventListener('click',
        function(e) {
          var p = e.target;
          // If target is within toolbar ignore click
          while(p) {
            if (p == JSL.bar)
              return;
            p = p.parentNode;
          }
          JSL.clear();
          JSL.toggleOverlay(false);
          // Remove immediatly when clicked
          document.removeEventListener('click', arguments.callee, true);
        },
        true);
    }
    // Several sequences of events can lead to
    // this function being called twise. I'm too lazy too
    // use state variables so just do a try/catch and ignore
    // errors from removing a node which is not in the
    // document
    else {
      try {
        // Remove redraw of overlay
        window.removeEventListener('resize', JSL.resizeOverlay, true);
        // Remove shortcuts
        document.removeEventListener('keydown', JSL.searchShortcuts, true);
        // Remove overlay
        JSL.ROOT.removeChild(JSL.overlay);
      }
      catch(err) {
      }
    }
  };

// Toggle regex on/off
JSL.toggleRegex =
  function() {
    // If regex do don't a search until a valid
    // pattern is entered
    if (JSL.bar.rgx.checked) {
      try {
        JSL.KW_RGX = new RegExp('(' + JSL.KW + ')', 'm' + (!JSL.bar.usecase.checked ? 'i' : ''));
      }
      catch(err) {
        // Create new regex to get correct error message. Otherwise the error will always
        // be something like 'unmatched parenthesis'
        try {
          var x = new RegExp(JSL.KW,'');
        }
        catch(err2) {
          // Display regex error in toolbar
          JSL.bar.rgx.nextSibling.style.color = '#db1b1b';
          JSL.bar.rgx.nextSibling.firstChild.nodeValue = 'Regular expression ('+ err2.message +')';
          return;
        }
      }
    }
    // If not using a regex then escape all identifiers
    else
      JSL.KW_RGX = new RegExp('(' + JSL.KW.replace(/[\^\$\.\*\+\?\=\!\:\|\(\)\[\]\{\}\\\/]/g,function($0){return '\\' + $0;}) + ')', 'm' + (!JSL.bar.usecase.checked ? 'i' : ''));
    // Do new search
    JSL.search();
  };

// Toggle case sensitivity on/off
JSL.toggleCase =
  function(e) {
    // Toogle i attribute of regex
    JSL.KW_RGX = new RegExp(JSL.KW_RGX.source, 'm' + (!e.target.checked ? 'i' : ''));
    // Do new search
    JSL.search();
  };

// Get current keyword
JSL.getKW =
  function(e) {
    // If keyword did not change just return
    if (e.target.value == JSL.KW)
      return;
    JSL.KW = e.target.value;
    // Start searching in JSL.DELAY milliseconds unless
    // new characters are inputted
    if (JSL.getKW.op)
      clearTimeout(JSL.getKW.op);
    JSL.getKW.op = setTimeout(JSL.toggleRegex, JSL.DELAY);
  };

// For clearing timeout
JSL.getKW.op = null;

// Clear results
JSL.clear =
  function() {
    // Clear previous result
    var a = JSL.matches;
    var l = a.length;
    if (l) {
      for(var i=0; i<l; i++)
        a[i].r.parentNode.replaceChild(a[i].o, a[i].r); 
      JSL.matches = [];
      JSL.nodes = [];
    }
    // Disable next/prev buttons
    JSL.bar.next.disabled = true;
    JSL.bar.prev.disabled = true;
  };

// Search for keyword
// If e is not provided just do new search.
// This happens when case or regex is toggled
JSL.search =
  function() {
    JSL.clear();
    if (/^\s*$/.test(JSL.KW)) {
      JSL.toggleOverlay(false);
      return;
    }
    // If we got this far using a regex remove error messages
    // from searchbar
    JSL.bar.rgx.nextSibling.style.color = '#000';
    JSL.bar.rgx.nextSibling.firstChild.nodeValue = 'Regular expression';
    
    // ** BEGIN SEARCH ** //
    
    // Get all text nodes
    var span,tmp,mNew,mL;
    // Get all text nodes in document which matches the search
    var n = JSL.ROOT.getTextNodes();
    // Number og matching text nodes. We don't yet know
    // how many matches we have. Each textnode in n can have multiple
    // matches.
    var l = n.length;
    // Number of found matches
    var m = 0;
    // Create regex with global flag. We can't use g flag when searching so have to set it here
    var rgx = new RegExp(JSL.KW_RGX.source,'gm' + (JSL.KW_RGX.ignoreCase ? 'i' : ''));
    // For each text noded in document which matches keyword
    for(var i=0; i<l; i++) {
      // IE specific checks
      // 1. If replacing the content of a PRE tag using innerHTML then all newlines
      //    is stripped. Oddly IE uses \r and not \n for newlines in PRE tags.
      if (document.createEventObject && n[i].parentNode.nodeName.toLowerCase() == 'pre') {
        // Flag for PRE tag
        var checkPRE = true;
        // Replace \r with BELL character to avoid messing up existing text
        n[i].nodeValue = n[i].nodeValue.replace(/\r/gm,'\x07');
      }
      // Create replacement node for text node
      span = document.createElement('span');
      // Markup matching text from text node and set as innerHTML of
      // replacement node
      span.innerHTML = n[i].nodeValue.replace(rgx, '<span style="border: 1px solid #000; padding: 2px; background: #fff; color: #000; position: relative; margin: -2px; z-index: ' + (JSL.Z_INDEX + 1) + ';">$1</span>');
      // IE PRE tag cleanup
      if (checkPRE) {
        // Replace BELL character with \r everywhere we found it in the first place
        for(var j=0; j<span.childNodes.length; j++) {
          if (span.childNodes[j].nodeType == 3)
            span.childNodes[j].nodeValue = span.childNodes[j].nodeValue.replace(/\x07/gm,'\r');
        }
        
      }
      // Get all matches in replacement node
      mNew = span.getElementsByTagName('span');
      // Number of matches in replacement node
      mL = mNew.length;
      // Append replacement node to array of
      // matching nodes untill MAX_RESULTS
      // is reached
      var j = 0;
      while(j<mL && m < JSL.MAX_RESULTS) {
        // Do more cleanup for PRE tags in IE
        if (checkPRE) {
          mNew[j].firstChild.nodeValue = mNew[j].firstChild.nodeValue.replace(/\x07/gm,'\r');
        }
        JSL.nodes.push(mNew[j]);
        j++;
        m++;
      }
      // Final cleanup for PRE tags
      if (checkPRE) {
        n[i].nodeValue = n[i].nodeValue.replace(/\x07/gm,'\r');
        checkPRE = false;
      }
      // As we have already modified the innerHTML of the
      // replacement node we node to remove some nodes
      // in the event that MAX_RESULTS have been reached.
      // If a long paragraph of text is present in the document
      // this step is nessesary to enforce MAX_RESULTS.
      // While we have surplus nodes
      while(mL > j) {
        // Remove node
        span.removeChild(mNew[mL - 1]);
        mL--;
      }
      // Object which we are saving in match array
      tmp = {r:span};
      tmp.o = n[i].parentNode.replaceChild(span,n[i]);
      JSL.matches.push(tmp);
      // Break when max. results are reached
      if (m == JSL.MAX_RESULTS)
        break;
    }
    // Setup buttons and shortcuts
    if (m >= JSL.MAX_RESULTS)
      JSL.bar.numResults.firstChild.nodeValue = JSL.MAX_RESULTS + ' or more results';
    else
      JSL.bar.numResults.firstChild.nodeValue = m + ' result' + (m != 1 ? 's' : '');
    // Enable overlay if any results
    if (m) {
      if (!JSL.overlay)
        JSL.createOverlay();
      JSL.toggleOverlay(true);
    }
    // Enable prev/next buttons
    if (m < 2) {
      JSL.bar.next.disabled = true;
      JSL.bar.prev.disabled = true;
    }
    else {
      JSL.bar.next.disabled = false;
      JSL.bar.prev.disabled = false;
    }
    // If any matches were found
    if (m) {
      // Get first result
      JSL.nodes.index = JSL.nodes.length - 1;
      JSL.next(1);
    }
    // If no matches
    else
      JSL.toggleOverlay(false);
  };

// Move to next/prev match
JSL.next =
  function(d) {
    // Set style for previous match
    JSL.nodes[JSL.nodes.index].style.zIndex = JSL.Z_INDEX + 1;
    JSL.nodes[JSL.nodes.index].style.background = '#fff';
    JSL.nodes[JSL.nodes.index].style.padding = '2px';
    // Get next match
    if (JSL.nodes.index + d < 0)
      JSL.nodes.index = JSL.nodes.length - 1;
    else if (JSL.nodes.index + d == JSL.nodes.length)
      JSL.nodes.index = 0;
    else
      JSL.nodes.index += d;
    // Set style for current match
    JSL.nodes[JSL.nodes.index].style.zIndex = JSL.Z_INDEX + 2;
    JSL.nodes[JSL.nodes.index].style.background = '#ff0';
    JSL.nodes[JSL.nodes.index].style.padding = '4px 2px';
    // Scroll to current match
    JSL.scrollToCurrent();
    // Animate current match
    JSL.animateCurrent();
  };

// Make current match stand out by doing
// a little animation
JSL.animateCurrent =
  function() {
    // Create a node identical to the current match
    var o = JSL.nodes[JSL.nodes.index];
    var c = o.cloneNode(true);
    var p = o.getPosition();
    // Hide current match
    o.style.visibility = 'hidden';
    // Position cloned node absolute to avoid affecting
    // the document when changing CSS
    c.style.position = 'absolute';
    c.style.left = p.x + 1 + 'px';
    c.style.top = p.y + 4 + 'px';
    c.style.background = '#ff0';
    c.style.zIndex = JSL.Z_INDEX + 4;
    document.body.appendChild(c);
    var dir = 1;
    // Setup function for doing animation
    var op = setInterval(
      function() {
        // Change the font size up and down
        var fs = parseFloat(c.style.fontSize) || 1.01;
        if (dir == 1)
          fs += 0.1;
        else
          fs -= 0.1;
        if (fs > 1.5)
          dir = -1;
        if (fs <= 1) {
          c.style.fontSize = '';
          // End animation
          clearInterval(op);
          document.body.removeChild(c);
          o.style.visibility = 'visible';
        }
        c.style.fontSize = fs + 'em';
      }, 20);
  };

// Scroll to current node
JSL.scrollToCurrent =
  function() {
    // scrollIntoView() will place the current element below the
    // searchbar so we can't use that
    var p = JSL.nodes[JSL.nodes.index].getPosition();
    window.scrollTo(p.x - 100, p.y - 100);
  };

// Shortcuts active when toolbar is showing
JSL.shortcuts =
  function(e) {
    // ESC - close
    if (e.keyCode == 27)
      JSL.closeToolbar();
    // CTRL + ALT + c - toggle case-sensitive
    else if (e.ctrlKey && e.altKey && e.keyCode == 67) {
      // Generate click on checkbox
      // Non-UEM IE defect
      if (document.createEventObject)
        JSL.bar.usecase.click();
      else {
        var evt = document.createEvent('MouseEvent');
        evt.initMouseEvent('click',true,true,window,1,0,0,0,0,0,false,false,false,0,null);
        JSL.bar.usecase.dispatchEvent(evt);
      }
    }
    // CTRL + ALT + r - toggle regex
    else if (e.ctrlKey && e.altKey && e.keyCode == 82) {
      // Generate click on checkbox
      // Non-UEM IE defect
      if (document.createEventObject)
        JSL.bar.rgx.click();
      else {
        var evt = document.createEvent('MouseEvent');
        evt.initMouseEvent('click',true,true,window,1,0,0,0,0,0,false,false,false,0,null);
        JSL.bar.rgx.dispatchEvent(evt);
      }
    }
  };

// Shotcuts active when overlay is showing
JSL.searchShortcuts =
  function(e) {
    // CTRL + ALT + n - next result
    if (e.ctrlKey && e.altKey && e.keyCode == 78)
      JSL.next(1);
    // CTRL + ALT + p - previous result
    else if (e.ctrlKey && e.altKey && e.keyCode == 80)
      JSL.next(-1);
  };

// Attach the toolbar to the document
JSL.openToolbar =
  function() {
    // Insert toolbar into document
    var body = document.documentElement.childNodes[1];
    body.insertBefore(JSL.bar, body.firstChild);
    // Move body to make room for toolbar
    body.style.marginTop = JSL.bar.offsetHeight + 'px';
    // Add shortcuts
    document.addEventListener('keydown', JSL.shortcuts, true);
    JSL.bar.kw.focus();
  };

// Remove the toolbar from the document
JSL.closeToolbar =
  function() {
    // Clear search results
    JSL.clear();
    // Remove overlay
    JSL.toggleOverlay(false);
    // Shortcut
    var body = document.documentElement.childNodes[1];
    // Remove toolbar
    body.removeChild(JSL.bar);
    // Reset body margin
    body.style.marginTop = 0;
    // Remove shortcuts
    document.removeEventListener('keydown', JSL.shortcuts, true);
    // Setup shortcut for opening toolbar
    document.addEventListener('keydown',
      function(e) {
        // CTRL + ALT + f
        if (e.ctrlKey && e.altKey && e.keyCode == 70) {
          // Prevent opening of native browser file menu
          e.preventDefault();
          JSL.openToolbar();
          // Remove immediatly to avoid opening another toolbar
          document.removeEventListener('keydown', arguments.callee, true);
        }
      },
      true);
  };

// Initialize script
JSL.main =
  function() {
    // Get reference to root search element
    JSL.ROOT = eval(JSL.ROOT);
    // Set number of search results to infinite if 0 is
    // specified
    if (!JSL.MAX_RESULTS)
      JSL.MAX_RESULTS = Number.POSITIVE_INFINITY;
    // Rewrite ignored tags to regex
    JSL.IGNORE_TAGS = new RegExp(JSL.IGNORE_TAGS.join('|'),'i');
    // Create toolbar
    JSL.createToolbar();
    // Open toolbar on load if selected by user
    if (JSL.SHOW_ON_LOAD)
      JSL.openToolbar();
    // Else set up shortcut for opening toolbar
    else {
      document.addEventListener('keydown',
        function(e) {
          // CTRL + ALT + f
          if (e.ctrlKey && e.altKey && e.keyCode == 70) {
            // Prevent opening of native browser file menu
            e.preventDefault();
            JSL.openToolbar();
            // Remove immediatly to avoid opening another toolbar
            document.removeEventListener('keydown', arguments.callee, true);
          }
        },
        true);
    }
  };

// Run script onload
window.addEventListener('load', JSL.main, false);
